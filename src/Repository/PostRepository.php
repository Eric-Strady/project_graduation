<?php

namespace App\Repository;

use App\Entity\Post;
use App\Filter\PostFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findAllPostsQuery(PostFilter $postFilter){
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.created_at', 'DESC');

        if ($postFilter->getYear())
        {
            $date_min = new \DateTime();
            $date_min->setDate($postFilter->getYear(), 1, 1)->setTime(0, 0);
            $date_max = new \DateTime();
            $date_max->setDate($postFilter->getYear(), 12, 31)->setTime(0, 0);

            $query = $query
                ->andWhere('p.created_at BETWEEN :date_min AND :date_max')
                ->setParameter('date_min', $date_min)
                ->setParameter('date_max', $date_max);
        }

        if ($postFilter->getPostCategories()->count() > 0)
        {
            $query = $query
                ->andWhere('p.category IN (:postCategory)')
                ->setParameter('postCategory', $postFilter->getPostCategories());
        }

        return $query->getQuery();
    }

    public function findLastPosts()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.created_at', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    public function countPosts()
    {
        return $this->createQueryBuilder('p')
            ->select('count(p)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
