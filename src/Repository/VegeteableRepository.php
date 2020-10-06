<?php

namespace App\Repository;

use App\Entity\Vegetable;
use DateTime;
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


    public function getRandomVegeteableMonth()
    {
        $date = new DateTime();
        $MonthDate = $date->format('M');
        $limit = 3;
        $qb = $this->_em->createQueryBuilder();
        $qb->select('v')
            ->from(Vegetable::class, 'v')
            ->where('v.harvestMonth LIKE :month ')
            ->setParameter('month', $MonthDate)
            ->orderBy('RAND()')
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

     /**
    * @return Vegeteable[] Returns an array of Vegeteable objects
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
