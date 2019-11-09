<?php

namespace App\Repository;

use App\Entity\Indemnite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Indemnite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Indemnite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Indemnite[]    findAll()
 * @method Indemnite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IndemniteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Indemnite::class);
    }

    // /**
    //  * @return Indemnite[] Returns an array of Indemnite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Indemnite
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
