import os
import pycurl
import yaml
import MySQLdb
from StringIO import StringIO
from datetime import datetime, timedelta

# Read parameters file
f = open('parameters.yml')
parameters = yaml.safe_load(f)
f.close()

# Connect to database
db = parameters['database']
con = MySQLdb.connect(db['server'], db['user'], db['password'], db['name'])
cur = con.cursor(MySQLdb.cursors.DictCursor)

# Get data from database
cur.execute('SELECT id, code FROM station')
stations = cur.fetchall()
cur.execute('SELECT id, code FROM item')
items = cur.fetchall()
cur.execute('SELECT id, code FROM technique')
techniques = cur.fetchall()
cur.execute('SELECT id, station_id, item_id FROM station_item')
station_item = {}
for rel in cur.fetchall():
    if int(rel['station_id']) not in station_item:
        station_item[int(rel['station_id'])] = {}
    station_item[int(rel['station_id'])][int(rel['item_id'])] = int(rel['id'])

# Read open data file
buffer = StringIO()
c = pycurl.Curl()
c.setopt(c.URL, parameters['data']['url'])
c.setopt(c.WRITEDATA, buffer)
c.perform()
c.close()
collection = buffer.getvalue().splitlines()
date_time = datetime.strptime(collection[0][20:30], '%Y,%m,%d')
date = date_time.strftime('%Y-%m-%d')

# Create a new raw data file
now = datetime.now()
folder = parameters['data']['folder']+'/'+str(now.year)+'-'+str(now.month)+'-'+str(now.day)
if not os.path.exists(folder):
    os.makedirs(folder)
with open(folder+'/'+str(now.hour)+':'+str(now.minute)+'.txt', 'w+') as f:
    f.write(buffer.getvalue())

# Get record for 00:00 of the current date
cur.execute("SELECT station_item_id, value_00 FROM records WHERE date = %s", [date])
value_00_collection = {}
for rel in cur.fetchall():
    value_00_collection[int(rel['station_item_id'])] = {}
    value_00_collection[int(rel['station_item_id'])]['value'] = rel['value_00']

# Delete records for current date
cur.execute("""DELETE FROM records WHERE date >= %s""", [date])
con.commit()

# Insert records into database
for line in collection:
    station_code = line[0:10].replace(',', '')
    item_code = line[11:13]
    technique_code = line[14:16]
    analysis_period = line[17:19]
    station_id = int((station for station in stations if station["code"] == station_code).next()['id'])
    item_id = int((item for item in items if item["code"] == item_code).next()['id'])
    station_item_id = station_item[station_id][item_id]
    technique_id = (item for item in techniques if item["code"] == technique_code).next()['id']
    records = line[31:].split(',')
    fields = 'station_item_id, technique_id, date, value_00'
    fields_index = '%s, %s, %s, %s'
    value_00 = value_00_collection[station_item_id]['value'] if station_item_id in value_00_collection else None
    values = [station_item_id, technique_id, date, value_00]
    hour = 1
    for i in range(0, len(records), 2):
        record = records[i:i+2]
        if hour == 24:
            cur.execute(
                "INSERT INTO records (station_item_id, technique_id, date, value_00) VALUES (%s, %s, %s, %s)",
                [station_item_id, technique_id, date_time + timedelta(days=1), record[0]]
            )        
        else:
            if hour < 10:
                fields += ', value_0'+str(hour)
            else:
                fields += ', value_'+str(hour)
            fields_index += ', %s'
            values.append(record[0] if record[1] == 'V' else None)
        hour += 1
    cur.execute("INSERT INTO records ("+fields+") VALUES ("+fields_index+")", values)
con.commit()

# Insert average records into database
cur.execute('SET @date = \''+date+'\'')
for line in open('InsertAverageRecords.sql'):
    cur.execute(line)
con.commit()
