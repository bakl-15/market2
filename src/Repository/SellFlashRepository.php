<?php

namespace App\Repository;

use App\Entity\SellFlash;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SellFlash|null find($id, $lockMode = null, $lockVersion = null)
 * @method SellFlash|null findOneBy(array $criteria, array $orderBy = null)
 * @method SellFlash[]    findAll()
 * @method SellFlash[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SellFlashRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SellFlash::class);
    }

    // /**
    //  * @return SellFlash[] Returns an array of SellFlash objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SellFlash
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
