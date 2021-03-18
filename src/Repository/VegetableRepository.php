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
class VegetableRepository extends ServiceEntityRepository
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
     * @param $search
     * @return Vegetable|null Returns an array of Vegetable objects
     */


    public function findBySearch(?string $search)
    {
        return $this->createQueryBuilder('v')
            ->Where("v.name LIKE :search")
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult();
    }
}
