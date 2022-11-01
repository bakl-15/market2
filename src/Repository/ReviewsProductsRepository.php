<?php

namespace App\Repository;

use App\Entity\ReviewsProducts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReviewsProducts|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReviewsProducts|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReviewsProducts[]    findAll()
 * @method ReviewsProducts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewsProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReviewsProducts::class);
    }

    // /**
    //  * @return ReviewsProducts[] Returns an array of ReviewsProducts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReviewsProducts
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
