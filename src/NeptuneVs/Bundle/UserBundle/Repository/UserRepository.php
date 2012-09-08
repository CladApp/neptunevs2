<?php

namespace NeptuneVs\Bundle\UserBundle\Repository;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository {
    
    public function findAllEnabledUsersAndUnlocked()
    {
        return $this->createQueryBuilder('t')
                        ->andWhere('t.enabled = true')
                        ->andWhere('t.locked = false')
                        ->orderBy("t.nom", 'ASC')
                        ->getQuery()
                        ->getResult();
    }
    
}