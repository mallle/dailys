<?php

namespace App\Repository;

use App\Entity\MonthToHabit;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

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


    /**
     * @param User $user
     * @return MonthToHabit|null
     * @throws NonUniqueResultException
     */
   public function findMonthToHabitForUser(User $user): ?MonthToHabit
   {
       return $this->createQueryBuilder('m')
           ->leftJoin('m.habit', 'h')
           ->andWhere('h.user = :user')
           ->setParameter('user', $user)
           ->getQuery()
           ->getOneOrNullResult()
       ;
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
