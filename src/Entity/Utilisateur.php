<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur implements UserInterface
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
     *
     * @ORM\ManyToMany (targetEntity="App\Entity\Sortie", inversedBy="participants", cascade={"persist"})
     */
    private $sortiesUtilisateurs;


    /**
     * @ORM\OneTomany(targetEntity="App\Entity\Sortie", mappedBy="organisateur")
     */
    private $sortiesOrganisees;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="utilisateurs")
     */
    private $site;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $admin;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $actif;

    /**
     * @ORM\Column(type="json")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="utilisateur", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }


    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(?bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }


    public function getSortiesOrganisees()
    {
        return $this->sortiesOrganisees;
    }


    public function setSortiesOrganisees($sortiesOrganisees)
    {
        $this->sortiesOrganisees = $sortiesOrganisees;
        return $this;
    }


    public function getSite()
    {
        return $this->site;
    }


    public function setSite($site)
    {
        $this->site = $site;
        return $this;
    }

    public function getRoles(): iterable
    {
        return $this->roles;
    }

    public function getSalt()
    {
        return null;
    }

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->images = new ArrayCollection();
    }

    public function eraseCredentials()
    {
        // $this->password = '';
        return null;
    }


    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setUtilisateur($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getUtilisateur() === $this) {
                $image->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function addSort($sort)
    {
        if (!$this->sortiesUtilisateurs->contains($sort)) {
            $this->sortiesUtilisateurs[] = $sort;
        }
        return $this;
    }

    public function removeSort($sort)
    {
        if ($this->sortiesUtilisateurs->contains($sort)) {
            $this->sortiesUtilisateurs->removeElement($sort);

        }
        return $this;
    }

    public function getSortiesUtilisateurs()
    {
        return $this->sortiesUtilisateurs;
    }

    public function setSortiesUtilisateurs($sortiesUtilisateurs)
    {
        $this->sortiesUtilisateurs = $sortiesUtilisateurs;
        return $this;
    }


}
