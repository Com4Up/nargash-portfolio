<?php

namespace App\Repository;

use App\Entity\Bio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bio[]    findAll()
 * @method Bio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bio::class);
    }

    // /**
    //  * @return Bio[] Returns an array of Bio objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bio
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findFirst() {
        return $this->createQueryBuilder('f')
        ->setMaxResults(1)
        ->orderBy('f.id', 'ASC')
        ->getQuery()
        ->getOneOrNullResult()
        ;
        }
}
