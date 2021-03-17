<?php

namespace App\Repository;

use App\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    public function getAvailableActivities($userid): array
    {
        return $this->createQueryBuilder('a')
                    ->leftJoin('a.users', 'u', Join::WITH, 'u.id = :userid')
                    ->where('u.id IS NULL')
                    ->setParameter('userid', $userid)
                    ->orderBy('a.date')
                    ->getQuery()
                    ->getResult()
            ;
    }

    public function getRegisteredActivities($userid): array
    {
        return $this->createQueryBuilder('a')
                    ->join('a.users', 'u')
                    ->where('u.id = :userid')
                    ->setParameter('userid', $userid)
                    ->join('a.activityType', 't')
                    ->addSelect('partial t.{id,price}')
                    ->orderBy('a.date')
                    ->getQuery()
                    ->getResult()
            ;
    }


    public function findAll(): array
    {
        return $this->findBy([], ['date' => 'ASC']);
    }

    public function getTotalActivities(): int
    {
        return $this->createQueryBuilder('a')
                    ->select('COUNT(a.id)')
                    ->getQuery()
                    ->getSingleScalarResult()
            ;
    }
}
