<?php

namespace App\Repository;

use App\Entity\Grower;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Grower|null find($id, $lockMode = null, $lockVersion = null)
 * @method Grower|null findOneBy(array $criteria, array $orderBy = null)
 * @method Grower[]    findAll()
 * @method Grower[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GrowerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grower::class);
    }

    // /**
    //  * @return Grower[] Returns an array of Grower objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Grower
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
