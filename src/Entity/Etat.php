<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatRepository::class)
 */
class Etat
{

    public function __toString():string{
        return $this->getLibelle();
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="etat")
     */
    private $sorties;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }


    public function getSorties()
    {
        return $this->sorties;
    }


    public function setSorties($sorties)
    {
        $this->sorties = $sorties;
        return $this;
    }

}
