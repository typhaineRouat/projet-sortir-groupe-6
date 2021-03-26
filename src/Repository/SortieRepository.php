<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Sortie;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

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
    public function findSearch(SearchData $search, Utilisateur $user)
    {

        $query = $this->createQueryBuilder('s')
            ->select('u', 's')
            ->leftJoin('s.participants', 'u')
            ->orderBy('s.dateHeureDebut', 'ASC');


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
        if (!empty($search->sortieInscrit)) {
            $query = $query
                ->andWhere(':sortieInscrit member of s.participants ')
                ->setParameter('sortieInscrit', $user->getId());

        }
        if (!empty($search->sortiePasInscrit)) {
            $query = $query
                ->andWhere(':sortiePasInscrit NOT MEMBER OF s.participants')
                ->setParameter('sortiePasInscrit', $user->getId());

        }
        if (!empty($search->sortieOrga)) {
            $query = $query
                ->andWhere('s.organisateur = :sortieOrga')
                ->setParameter('sortieOrga', $user->getId());

        }


        return $query->getQuery()->getResult();
    }

}
