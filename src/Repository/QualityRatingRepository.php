<?php

namespace App\Repository;

use App\Entity\QualityRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QualityRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method QualityRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method QualityRating[]    findAll()
 * @method QualityRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QualityRatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QualityRating::class);
    }

    // /**
    //  * @return QualityRating[] Returns an array of QualityRating objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QualityRating
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
