<?php

namespace App\Repository;

use App\Entity\About;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method About|null find($id, $lockMode = null, $lockVersion = null)
 * @method About|null findOneBy(array $criteria, array $orderBy = null)
 * @method About[]    findAll()
 * @method About[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AboutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, About::class);
    }

    public function findAbout()
    {
        return $this->createQueryBuilder('a')
            ->getQuery()
            ->getSingleResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?About
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
