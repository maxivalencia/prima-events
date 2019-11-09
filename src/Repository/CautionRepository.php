<?php

namespace App\Repository;

use App\Entity\Caution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Caution|null find($id, $lockMode = null, $lockVersion = null)
 * @method Caution|null findOneBy(array $criteria, array $orderBy = null)
 * @method Caution[]    findAll()
 * @method Caution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CautionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Caution::class);
    }

    // /**
    //  * @return Caution[] Returns an array of Caution objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Caution
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
