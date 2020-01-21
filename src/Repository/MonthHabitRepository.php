<?php

namespace App\Repository;

use App\Entity\MonthHabit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MonthHabit|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonthHabit|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonthHabit[]    findAll()
 * @method MonthHabit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonthHabitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonthHabit::class);
    }

    // /**
    //  * @return MonthHabit[] Returns an array of MonthHabit objects
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
    public function findOneBySomeField($value): ?MonthHabit
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
