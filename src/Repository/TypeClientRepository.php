<?php

namespace App\Repository;

use App\Entity\TypeClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeClient[]    findAll()
 * @method TypeClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeClient::class);
    }

    // /**
    //  * @return TypeClient[] Returns an array of TypeClient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeClient
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
