<?php

namespace App\Repository;

use App\Entity\ReportGenerator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReportGenerator|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportGenerator|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportGenerator[]    findAll()
 * @method ReportGenerator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportGeneratorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportGenerator::class);
    }

    // /**
    //  * @return ReportGenerator[] Returns an array of ReportGenerator objects
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
    public function findOneBySomeField($value): ?ReportGenerator
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
