<?php

namespace App\Repository;

use App\Entity\RetourArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RetourArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method RetourArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method RetourArticle[]    findAll()
 * @method RetourArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetourArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RetourArticle::class);
    }

    // /**
    //  * @return RetourArticle[] Returns an array of RetourArticle objects
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
    public function findOneBySomeField($value): ?RetourArticle
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
