<?php

namespace App\Repository;

use App\Entity\SortieArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SortieArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method SortieArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method SortieArticle[]    findAll()
 * @method SortieArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SortieArticle::class);
    }

    // /**
    //  * @return SortieArticle[] Returns an array of SortieArticle objects
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
    public function findOneBySomeField($value): ?SortieArticle
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
