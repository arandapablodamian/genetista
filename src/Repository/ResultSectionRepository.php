<?php

namespace App\Repository;

use App\Entity\ResultSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResultSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResultSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResultSection[]    findAll()
 * @method ResultSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResultSection::class);
    }

    // /**
    //  * @return ResultSection[] Returns an array of ResultSection objects
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
    public function findOneBySomeField($value): ?ResultSection
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
