<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RecordsRepository extends EntityRepository
{
    public function getCollection($stationId, $itemIdCollection, $startDate, $endDate, $last24Hours = false)
    {
        $currentDate = new \DateTime();
        if ($currentDate->format('Y-m-d') == $endDate->format('Y-m-d')) {
            if ($endDate->format('i') < 40) {
                $endDate->sub(new \DateInterval('PT1H'));
            }
        }
        $records = $this->getEntityManager()->createQuery(
            'SELECT e.id, e.date, IDENTITY(r.item) AS itemId,
                e.value00,
                e.value01,
                e.value02,
                e.value03,
                e.value04,
                e.value05,
                e.value06,
                e.value07,
                e.value08,
                e.value09,
                e.value10,
                e.value11,
                e.value12,
                e.value13,
                e.value14,
                e.value15,
                e.value16,
                e.value17,
                e.value18,
                e.value19,
                e.value20,
                e.value21,
                e.value22,
                e.value23
            FROM AppBundle:Records e
            LEFT JOIN AppBundle:StationItem r WITH r = e.stationItem
            WHERE IDENTITY(r.station) = :stationId AND IDENTITY(r.item) IN(:itemIdCollection) AND (e.date BETWEEN :startDate AND :endDate)
            ORDER BY e.date ASC'
        )->setParameters([
            'stationId' => $stationId,
            'itemIdCollection' => $itemIdCollection,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
        ])->getResult();
        $collection = [];
        foreach ($records as $record) {
            for ($i = 0; $i <= 23; ++$i) {
                $collection[$record['itemId']][$record['date']->format('d-m-Y')][] = [
                    'value' => $record['value'.sprintf('%02d', $i)],
                ];
            }
        }
        if ($currentDate->format('Y-m-d') == $endDate->format('Y-m-d')) {
            $limit = $endDate->format('H') + 1;
            foreach ($collection as $itemId => &$collectionByDate) {
                if (isset($collectionByDate[$currentDate->format('d-m-Y')])) {
                    $collectionByDate[$currentDate->format('d-m-Y')] = array_slice($collectionByDate[$currentDate->format('d-m-Y')], 0, $limit);
                }
            }
            if ($last24Hours) {
                $startDate = $endDate->sub(new \DateInterval('P1D'));
                foreach ($collection as $itemId => &$collectionByDate) {
                    $collectionByDate[$startDate->format('d-m-Y')] = array_slice($collectionByDate[$startDate->format('d-m-Y')], 1 + $startDate->format('G'), null, true);
                }
            }
        }

        return $collection;
    }
}
