<?php

namespace App\Repository;

use App\Entity\RetourClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RetourClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method RetourClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method RetourClient[]    findAll()
 * @method RetourClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetourClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RetourClient::class);
    }

    // /**
    //  * @return RetourClient[] Returns an array of RetourClient objects
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
    public function findOneBySomeField($value): ?RetourClient
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
