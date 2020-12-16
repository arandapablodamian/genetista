<?php

namespace App\Repository;

use App\Entity\ResultSubsection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResultSubsection|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResultSubsection|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResultSubsection[]    findAll()
 * @method ResultSubsection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultSubsectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResultSubsection::class);
    }

    // /**
    //  * @return ResultSubsection[] Returns an array of ResultSubsection objects
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
    public function findOneBySomeField($value): ?ResultSubsection
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
