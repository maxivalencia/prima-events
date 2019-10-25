<?php

namespace App\Repository;

use App\Entity\TypePayement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypePayement|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypePayement|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypePayement[]    findAll()
 * @method TypePayement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypePayementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypePayement::class);
    }

    // /**
    //  * @return TypePayement[] Returns an array of TypePayement objects
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
    public function findOneBySomeField($value): ?TypePayement
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
