<?php

namespace App\Repository;

use App\Entity\Hobbie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Hobbie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hobbie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hobbie[]    findAll()
 * @method Hobbie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HobbieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Hobbie::class);
    }

    // /**
    //  * @return Hobbie[] Returns an array of Hobbie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hobbie
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    const MAX_RESULT = 3; 
    public function myGetProjet($page)
    {
        return $this->createQueryBuilder('b')
        ->setFirstResult(($page-1)*self::MAX_RESULT)
        ->setMaxResults(self::MAX_RESULT)
        // ->orderBy('b.date','ASC')
        ->getQuery()
        ->getResult()
        ;
    }
    public function myProjetSearch($search)
    {
        return $this->createQueryBuilder('b')
        ->where('b.titre LIKE :search')
        ->setParameter('search', '%'.$search.'%')
        ->setMaxResults(self::MAX_RESULT)
        // ->orderBy('b.date','ASC')
        ->getQuery()
        ->getResult()
        ;
    }
    public function myGetProjetByType($type,$page)
    {
        $query =  $this->createQueryBuilder('b')
        ->where('b.type = :type')
        ->setParameter('type', $type)
        ->setFirstResult(($page-1)*self::MAX_RESULT)
        ->setMaxResults(self::MAX_RESULT)
        // ->orderBy('b.date','ASC')
      
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
}
