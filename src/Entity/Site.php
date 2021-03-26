<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SiteRepository::class)
 */
class Site
{
    public function __toString(): string
    {
        return $this->getNom();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="SiteOrga")
     */
    private $sortiesParSite;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Utilisateur", mappedBy="site")
     */
    private $utilisateurs;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }


    public function getSortiesParSite()
    {
        return $this->sortiesParSite;
    }


    public function setSortiesParSite($sortiesParSite)
    {
        $this->sortiesParSite = $sortiesParSite;
        return $this;
    }


    public function getUtilisateurs()
    {
        return $this->utilisateurs;
    }


    public function setUtilisateurs($utilisateurs)
    {
        $this->utilisateurs = $utilisateurs;
        return $this;
    }


}
