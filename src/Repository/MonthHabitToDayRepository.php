<?php

namespace App\Repository;

use App\Entity\MonthHabitToDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MonthHabitToDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonthHabitToDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonthHabitToDay[]    findAll()
 * @method MonthHabitToDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonthHabitToDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonthHabitToDay::class);
    }

    // /**
    //  * @return MonthHabitToDay[] Returns an array of MonthHabitToDay objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MonthHabitToDay
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
