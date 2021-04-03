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

    public function getAvailableActivities($userid)
    {
        return $this->createQueryBuilder('a')
                    ->select('a.id, a.datetime, a.maxRegistrations')
                    ->leftJoin('a.users', 'u', Join::WITH, 'u.id = :userid')
                    ->andWhere('u.id IS NULL')
                    ->join('a.activityType', 'at')
                    ->addSelect('at.price, at.name')
                    ->leftJoin('a.users', 'uc')
                    ->addSelect('COUNT(uc.id) as totalRegistrations')
                    ->andWhere('a.datetime >= CURRENT_DATE()')
                    ->setParameter('userid', $userid)
                    ->having('a.maxRegistrations > totalRegistrations')
                    ->orderBy('a.datetime')
                    ->groupBy('a.id')
                    ->getQuery()
                    ->getResult()
            ;
    }

    public function getRegisteredActivities($userid): array
    {
        return $this->createQueryBuilder('a')
                    ->select('a.id, a.datetime, a.maxRegistrations')
                    ->join('a.users', 'u')
                    ->andWhere('u.id = :userid')
                    ->andWhere('a.datetime >= CURRENT_DATE()')
                    ->setParameter('userid', $userid)
                    ->join('a.activityType', 'at')
                    ->addSelect('at.price, at.name')
                    ->leftJoin('a.users', 'uc')
                    ->addSelect('COUNT(uc.id) as totalRegistrations')
                    ->orderBy('a.datetime')
                    ->groupBy('a.id')
                    ->getQuery()
                    ->getResult()
            ;
    }


    public function findAll(): array
    {
        return $this->findBy([], ['datetime' => 'ASC']);
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
