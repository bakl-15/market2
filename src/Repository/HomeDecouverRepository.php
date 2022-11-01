<?php

namespace App\Repository;

use App\Entity\HomeDecouver;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HomeDecouver|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomeDecouver|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomeDecouver[]    findAll()
 * @method HomeDecouver[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeDecouverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeDecouver::class);
    }

    // /**
    //  * @return HomeDecouver[] Returns an array of HomeDecouver objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HomeDecouver
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
