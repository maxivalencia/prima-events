<?php

namespace App\Repository;

use App\Entity\Paye;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Paye|null find($id, $lockMode = null, $lockVersion = null)
 * @method Paye|null findOneBy(array $criteria, array $orderBy = null)
 * @method Paye[]    findAll()
 * @method Paye[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PayeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paye::class);
    }

    // /**
    //  * @return Paye[] Returns an array of Paye objects
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
    public function findOneBySomeField($value): ?Paye
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
