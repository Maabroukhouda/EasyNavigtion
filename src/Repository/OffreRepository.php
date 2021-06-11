<?php

namespace App\Repository;

use App\Entity\Offre;
use App\Entity\Location;

use Symfony\Component\Validator\Constraints\Date;

use App\Entity\VoyageOrganiser;
use App\Entity\VoyageRegulier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }
    /**
     * @return Offre[]
     */

    public function FilterDate(?int $min_prix, ?int $max_prix, ?int $min_nb_place, $depart,$destiantion, bool $includeUnavailableProducts = false): array
    {
        $qb = $this->createQueryBuilder('p');
        // ->select('p');
        //'L', 'p', 'VR', 'VO')
        // ->leftJoin('p.voyageOrganiser', 'VO')
        //->leftJoin('p.voyageRegulier', 'VR')
        //->leftJoin('p.location', 'L');

        if ($min_prix != null) {

            $qb = $qb->where('p.prix >= :minprix')
                //->orWhere('VO.prix >= :minprix')
                //->orWhere('VR.Prix >= :minprix')
                ->setParameter('minprix', $min_prix);
        }
        if ($max_prix != null) {
            $qb = $qb->andWhere('p.prix <= :maxprix')
                //->orWhere('VO.prix <= :maxprix')
                //->orWhere('VR.Prix <= :maxprix')
                ->setParameter('maxprix', $max_prix);
        }
        if ($min_nb_place != null) {
            $qb = $qb->andWhere('p.nbplace >= :nb_place')
                //->andWhere('VO.nbplace >= :nb_place OR VR.nbPlace >= :nb_place ')
                //->andWhere('VO.nbplace >= :nb_place')
                // ->orWhere('VR.nbPlace >= :nb_place')
                ->setParameter('nb_place', $min_nb_place);
        }
        /*if (!empty($date)) {
            $qb = $qb->where('VO.date <= :date')
                ->setParameter('date', $date);
        }*/
        $query = $qb->getQuery();
        return $query->execute();
    }
    /*
    public function findDate(int $date, bool $includeUnavailableProducts = false): array
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.date = :date')
            ->setParameter('date', $date);
        if (!$includeUnavailableProducts) {
            $qb->orWhere('p.available = TRUE');
        }
    }
    
    public function findOffre(int $date, bool $includeUnavailableProducts = false): array
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.date = :date')
            ->setParameter('date', $date);
        if (!$includeUnavailableProducts) {
            $qb->orWhere('p.available = TRUE');
        }

        $query = $qb->getQuery();

        return $query->execute();
    }
    
    public function findMinPrix(int $minprix, bool $includeUnavailableProducts = false): array
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.prix <= :prix')
            ->setParameter('prix', $minprix);
        if (!$includeUnavailableProducts) {
            $qb->orWhere('p.available = TRUE');
        }

        $query = $qb->getQuery();

        return $query->execute();
    }
   
    public function findMaxPrix(int $maxprix, bool $includeUnavailableProducts = false): array
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.prix > :prix')
            ->setParameter('prix', $maxprix);
        if (!$includeUnavailableProducts) {
            $qb->orWhere('p.available = TRUE');
        }

        $query = $qb->getQuery();

        return $query->execute();
    }
   
    public function findMinPlace(int $min_nb_place, bool $includeUnavailableProducts = false): array
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.nbplace > :nbplace')
            ->setParameter('nbplace', $min_nb_place);
        if (!$includeUnavailableProducts) {
            $qb->orWhere('p.available = TRUE');
        }

        $query = $qb->getQuery();

        return $query->execute();
    }
   /
    public function findAllVisibleQuery(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT * FROM Offre ';
        $stmt = $conn->prepare($sql);
        return $stmt->fetchAllAssociative();
        /*$query = $this->findVisibleQuery()->getQuery();
        if ($search->getMixPrix(
            $query = $query->orWhere
        ))
            return $query->getResult();
    }*/



    // /**
    //  * @return Offre[] Returns an array of Offre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->orWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Offre
    {
        return $this->createQueryBuilder('o')
            ->orWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
