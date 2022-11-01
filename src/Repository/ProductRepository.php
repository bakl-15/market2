<?php

namespace App\Repository;

use App\Data\SearchProduct;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getProductBestNew()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.isNew = :val')
            ->andWhere('p.isBestSeller = :val1')
            ->setParameter('val', true)
            ->setParameter('val1', false)
            ->getQuery()
            ->getResult()
        ;
    }
    public function  getProductsBySearch( array $search){
        
        $product = $search['search'];
        $category =$search['category'];
        $qb =  $this->createQueryBuilder('p');
        
         $qb->leftJoin('p.category', 'c');

       if($search['search']){
            $qb->andwhere( $qb->expr()->like('p.name', ':name'))
            ->setParameter(':name', "%$product%" );
        }
        if($search['category']){
            $qb 
              ->andWhere($qb->expr()->eq('c.name', ':name'))
              ->setParameter(':name', $category->getName() );
          }
        
       return  $qb
        ->getQuery()
        ->getResult()
    ;
    }

    public function getProductsByFiltre(SearchProduct $search ){
        $q = $search->getQ();
        
         $qb = $this->createQueryBuilder('p');
         $qb
            ->select('p','c')
            ->join('p.category', 'c');

        if( !empty($search->getQ())){
            $qb->andwhere( $qb->expr()->like('p.name', ':name'))
            ->setParameter(':name', "%$q%" );
        } 
        if( !empty($search->getMinPrice())){
            $qb = $qb->andWhere('p.price >= :min')
                      ->setParameter('min', $search->getMinPrice());
          }  
        if( !empty($search->getMaxPrice())){
            $qb = $qb->andWhere('p.price <= :max')
                      ->setParameter('max', $search->getMaxPrice());
        }    
        if( !empty($search->getCategories())){
            $qb = $qb->andWhere('c.id IN(:categories)')
                      ->setParameter('categories', $search->getCategories());
        }   
        return $qb->getQuery()->getResult();
    }
   public function getMinMax(SearchProduct $search){
      return [0,100];
   }
}
