<?php

namespace App\Repository;

use App\Entity\NavLarge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NavLarge|null find($id, $lockMode = null, $lockVersion = null)
 * @method NavLarge|null findOneBy(array $criteria, array $orderBy = null)
 * @method NavLarge[]    findAll()
 * @method NavLarge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NavLargeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NavLarge::class);
    }

    // /**
    //  * @return NavLarge[] Returns an array of NavLarge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NavLarge
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
