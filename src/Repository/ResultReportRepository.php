<?php

namespace App\Repository;

use App\Entity\ResultReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResultReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResultReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResultReport[]    findAll()
 * @method ResultReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResultReport::class);
    }

    // /**
    //  * @return ResultReport[] Returns an array of ResultReport objects
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
    public function findOneBySomeField($value): ?ResultReport
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
