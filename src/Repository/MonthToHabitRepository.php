<?php

namespace App\Repository;

use App\Entity\MonthToHabit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MonthToHabit|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonthToHabit|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonthToHabit[]    findAll()
 * @method MonthToHabit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonthToHabitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonthToHabit::class);
    }

    // /**
    //  * @return MonthToHabit[] Returns an array of MonthToHabit objects
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
    public function findOneBySomeField($value): ?MonthToHabit
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
