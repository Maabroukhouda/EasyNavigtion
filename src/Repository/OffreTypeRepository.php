<?php

namespace App\Repository;

use App\Entity\OffreType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OffreType|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffreType|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffreType[]    findAll()
 * @method OffreType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreType::class);
    }

    // /**
    //  * @return OffreType[] Returns an array of OffreType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OffreType
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
