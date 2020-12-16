<?php

namespace App\Repository;

use App\Entity\ResultMarker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResultMarker|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResultMarker|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResultMarker[]    findAll()
 * @method ResultMarker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultMarkerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResultMarker::class);
    }

    // /**
    //  * @return ResultMarker[] Returns an array of ResultMarker objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResultMarker
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
