<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    /**
     * récupère les sorties en lien avec une recherche
     *
     */
    public function findSearch(SearchData $search)
    {
        $query = $this->createQueryBuilder('s');

        if (!empty($search->site)) {
            $query = $query
                ->andWhere('s.SiteOrga IN (:site)')
                ->setParameter('site', $search->site);
        }

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('s.nom LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->sortiePassee)) {
            $query = $query
                ->andWhere('s.etat = 5');
        }

        if (!empty($search->dateMin) && !empty($search->dateMax) && ($search->dateMax) >= ($search->dateMin)) {
            $query = $query

                ->andWhere('s.dateHeureDebut BETWEEN :dateMin AND :dateMax')
                ->setParameter('dateMin', $search->dateMin)
                ->setParameter('dateMax', $search->dateMax);

        }


        return $query->getQuery()->getResult();
    }


    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
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
    public function findOneBySomeField($value): ?Sortie
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
