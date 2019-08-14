<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function myGetArticle($page)
    {
        return $this->createQueryBuilder('b')
        ->setFirstResult(($page-1)*6)
        ->setMaxResults(6)
        ->orderBy('b.date','ASC')
        ->getQuery()
        ->getResult()
        ;
    }
    public function myLastArticle($maxResult)
    {
        return $this->createQueryBuilder('b')
        ->setMaxResults($maxResult)
        ->orderBy('b.date','ASC')
        ->getQuery()
        ->getResult()
        ;
    }
    public function myArticleSearch($search)
    {
        return $this->createQueryBuilder('b')
        // ->setFirstResult(($page-1)*6)
        ->where('b.titre LIKE :search')
        ->setParameter('search', '%'.$search.'%')
        ->setMaxResults(6)
        ->orderBy('b.date','ASC')
        ->getQuery()
        ->getResult()
        ;
    }
    public function myGetArticleByType($type,$page)
    {
        $query =  $this->createQueryBuilder('b')
        ->where('b.type = :type')
        ->setParameter('type', $type)
        ->setFirstResult(($page-1)*6)
        ->setMaxResults(6)
        ->orderBy('b.date','ASC')
      
        ->getQuery()
        ->getResult()
        ;
        return $query;
    }

    public function myCount()
    {
        return $this->createQueryBuilder('b')
            ->select('count(b)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
    public function myCountByTri($tri)
    {
        return $this->createQueryBuilder('b')
            ->select('count(b)')
            ->where("b.type like :type")
            ->setParameter("type" , $tri)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Article
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
