<?php

namespace App\Repository;

use App\Entity\Vegetable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vegetable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vegetable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vegetable[]    findAll()
 * @method Vegetable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VegeteableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vegetable::class);
    }

    // /**
    //  * @return Vegeteable[] Returns an array of Vegeteable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vegeteable
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
