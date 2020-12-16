<?php

namespace App\Repository;

use App\Entity\ReportGeneratorSecond;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReportGeneratorSecond|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportGeneratorSecond|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportGeneratorSecond[]    findAll()
 * @method ReportGeneratorSecond[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportGeneratorSecondRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportGeneratorSecond::class);
    }

    // /**
    //  * @return ReportGeneratorSecond[] Returns an array of ReportGeneratorSecond objects
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
    public function findOneBySomeField($value): ?ReportGeneratorSecond
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
