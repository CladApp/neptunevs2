<?php

namespace NeptuneVs\Bundle\AgendaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends EntityRepository {

    public function findByDate(\DateTime $start, \DateTime $end) {

        return $this->createQueryBuilder('e')
                        ->where('e.start >= :start')
                        ->andWhere('e.start <= :end')
                        ->setParameter('start', $start->format('Y-m-d H:i:s'))
                        ->setParameter('end', $end->format('Y-m-d H:i:s'))
                        ->getQuery()
                        ->getResult();
    }

    public function findByPlaceAndStart($placeId, \DateTime $start) {

        return $this->createQueryBuilder('e')
                        ->where('e.start = :start')
                        ->andWhere('e.place = :id')
                        ->setParameter('start', $start->format('Y-m-d H:i:s'))
                        ->setParameter('id', $placeId)
                        ->getQuery()
                        ->getResult();
    }

    public function findbyDayMonthYear($start) {
        $startDate = $start->format('Y-m-d');
        $endDate = $start->add(new \DateInterval('P1D'))->format('Y-m-d');
        
        return $this->createQueryBuilder('e')
                        ->where('e.start >= :start')
                        ->andWhere('e.end < :end')
                        ->setParameter('start', $startDate)
                        ->setParameter('end', $endDate)
                        ->getQuery()
                        ->getResult();
    }

}