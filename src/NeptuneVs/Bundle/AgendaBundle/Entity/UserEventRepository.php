<?php

namespace NeptuneVs\Bundle\AgendaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserEventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserEventRepository extends EntityRepository
{
    
    public function findByEventAndUserId($eventId, $userId) {
        
        return $this->createQueryBuilder('ue')
                        ->where('ue.event = :event')
                        ->andWhere('ue.user = :user')
                        ->setParameter('event', $eventId)
                        ->setParameter('user', $userId)
                        ->getQuery()
                        ->getResult();
    }
}