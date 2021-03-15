<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SiteRepository::class)
 */
class Site
{

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
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

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

    /**
     * @return ArrayCollection
     */
    public function getSortiesParSite(): ArrayCollection
    {
        return $this->sortiesParSite;
    }

    /**
     * @param ArrayCollection $sortiesParSite
     */
    public function setSortiesParSite(ArrayCollection $sortiesParSite): void
    {
        $this->sortiesParSite = $sortiesParSite;
    }


}
