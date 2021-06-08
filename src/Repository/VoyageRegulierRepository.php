<?php

namespace App\Repository;

use App\Entity\VoyageRegulier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VoyageRegulier|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoyageRegulier|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoyageRegulier[]    findAll()
 * @method VoyageRegulier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoyageRegulierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VoyageRegulier::class);
    }

    // /**
    //  * @return VoyageRegulier[] Returns an array of VoyageRegulier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VoyageRegulier
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
