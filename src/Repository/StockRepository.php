<?php

namespace App\Repository;

use App\Entity\Stock;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Stock|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stock|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stock[]    findAll()
 * @method Stock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stock::class);
    }

    /**
     * @return Stock[] Returns an array of Stock objects
     */
    public function findByGroup($value1, $value2)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.mouvement = :val1')
            ->andWhere('s.mode = :val2')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->groupBy('s.reference')
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Stock[] Returns an array of Stock objects
     */
    public function findHistorique()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.client IS NOT NULL')
            ->groupBy('s.reference')
            ->orderBy('s.id', 'DESC')
            //->setParameter('val1', null)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Stock[] Returns an array of Stock objects
     */
    public function findHistoriqueDetails($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.reference = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Stock[] Returns an array of Stock objects
     */
    public function findEtatStock($value1, $value2)
    {
        return $this->createQueryBuilder('s')
            ->where('s.article = :val1')
            ->andWhere('s.mode = :val2')
            ->setParameter('val1', $value1)            
            ->setParameter('val2', $value2)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Stock[] Returns an array of Stock objects
     */
    public function findEtatStockNeg($value1, $value2, $value3)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.mouvement = :val1')
            ->andWhere('s.article = :val2')
            ->andWhere('s.dateSortiePrevue = :val3 OR s.dateSortieEffectif = :val3')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->setParameter('val3', $value3)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Stock[] Returns an array of Stock objects
     */
    public function findEtatStockPos($value1, $value2, $value3)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.mouvement = :val1')
            ->andWhere('s.article = :val2')
            ->andWhere('s.dateRetourPrevu = :val3 OR s.dateRetourEffectif = :val3')
            ->setParameter('val1', $value1)
            ->setParameter('val2', $value2)
            ->setParameter('val3', $value3)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Stock[] Returns an array of Stock objects
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
    public function findOneBySomeField($value): ?Stock
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
