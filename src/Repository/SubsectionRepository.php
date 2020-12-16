<?php

namespace App\Repository;

use App\Entity\Subsection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Subsection|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subsection|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subsection[]    findAll()
 * @method Subsection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubsectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subsection::class);
    }

    // /**
    //  * @return Subsection[] Returns an array of Subsection objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Subsection
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
