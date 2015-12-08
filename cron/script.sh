#!/bin/bash
file=log/`date +"%Y-%m-%d.log"`;
echo  $'\r'"----- `date` -----"$'\r\r' >> $file; source ./environment/bin/activate; python ./EmissionsRealTime.py >> $file 2>&1;