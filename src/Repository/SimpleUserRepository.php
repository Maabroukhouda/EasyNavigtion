<?php

namespace App\Repository;

use App\Entity\SimpleUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SimpleUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method SimpleUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method SimpleUser[]    findAll()
 * @method SimpleUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SimpleUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SimpleUser::class);
    }

    // /**
    //  * @return SimpleUser[] Returns an array of SimpleUser objects
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
    public function findOneBySomeField($value): ?SimpleUser
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
