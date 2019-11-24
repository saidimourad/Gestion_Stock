<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="fournisseurs")
     */
    private $userfr;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="chefbureau")
     */
    private $userchb;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="chefunite")
     */
    private $userchu;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lingecommande", mappedBy="commande", fetch="EXTRA_LAZY",orphanRemoval=true,  cascade={"persist"})
     */
    private $lingecommandes;

    /**
     * @ORM\Column(type="integer")
     */
    private $refCommande;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCommande;

    /**
     * @ORM\Column(type="integer", options={"default" : 0}, nullable=true)
     */
    private $isAccept;

    /**
     * @ORM\Column(type="integer", options={"default" : 0}, nullable=true)
     */
    private $isValid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AnneeScolaire", inversedBy="commandes")
     */
    private $anneeScolaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Magasin", inversedBy="commandes")
     */
    private $magasin;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datelivraison;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entree", mappedBy="commande" )
     */
    private $entrees;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateprevulivraison;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $isLivre;


    public function __construct()
    {
        $this->lingecommandes = new ArrayCollection();
        $this->entrees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserfr(): ?User
    {
        return $this->userfr;
    }

    public function setUserfr(?User $userfr): self
    {
        $this->userfr = $userfr;

        return $this;
    }

    public function getUserchb(): ?User
    {
        return $this->userchb;
    }

    public function setUserchb(?User $userchb): self
    {
        $this->userchb = $userchb;

        return $this;
    }

    public function getUserchu(): ?User
    {
        return $this->userchu;
    }

    public function setUserchu(?User $userchu): self
    {
        $this->userchu = $userchu;

        return $this;
    }

    /**
     * @return Collection|Lingecommande[]
     */
    public function getLingecommandes(): Collection
    {
        return $this->lingecommandes;
    }

    public function addLingecommande(Lingecommande $lingecommande): self
    {
        if (!$this->lingecommandes->contains($lingecommande)) {
            $this->lingecommandes[] = $lingecommande;
            $lingecommande->setCommande($this);
        }

        return $this;
    }

    public function removeLingecommande(Lingecommande $lingecommande): self
    {
        if ($this->lingecommandes->contains($lingecommande)) {
            $this->lingecommandes->removeElement($lingecommande);
            // set the owning side to null (unless already changed)
            if ($lingecommande->getCommande() === $this) {
                $lingecommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getRefCommande(): ?int
    {
        return $this->refCommande;
    }

    public function setRefCommande(int $refCommande): self
    {
        $this->refCommande = $refCommande;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getIsAccept(): ?int
    {
        return $this->isAccept;
    }

    public function setIsAccept(?int $isAccept): self
    {
        $this->isAccept = $isAccept;

        return $this;
    }

    public function getIsValid(): ?int
    {
        return $this->isValid;
    }

    public function setIsValid(?int $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getAnneeScolaire(): ?AnneeScolaire
    {
        return $this->anneeScolaire;
    }

    public function setAnneeScolaire(?AnneeScolaire $anneeScolaire): self
    {
        $this->anneeScolaire = $anneeScolaire;

        return $this;
    }

    public function getMagasin(): ?Magasin
    {
        return $this->magasin;
    }

    public function setMagasin(?Magasin $magasin): self
    {
        $this->magasin = $magasin;

        return $this;
    }

    public function getDatelivraison(): ?\DateTimeInterface
    {
        return $this->datelivraison;
    }

    public function setDatelivraison(?\DateTimeInterface $datelivraison): self
    {
        $this->datelivraison = $datelivraison;

        return $this;
    }

    /**
     * @return Collection|Entree[]
     */
    public function getEntrees(): Collection
    {
        return $this->entrees;
    }

    public function addEntree(Entree $entree): self
    {
        if (!$this->entrees->contains($entree)) {
            $this->entrees[] = $entree;
            $entree->setCommande($this);
        }

        return $this;
    }

    public function removeEntree(Entree $entree): self
    {
        if ($this->entrees->contains($entree)) {
            $this->entrees->removeElement($entree);
            // set the owning side to null (unless already changed)
            if ($entree->getCommande() === $this) {
                $entree->setCommande(null);
            }
        }

        return $this;
    }

    public function getDateprevulivraison(): ?\DateTimeInterface
    {
        return $this->dateprevulivraison;
    }

    public function setDateprevulivraison(?\DateTimeInterface $dateprevulivraison): self
    {
        $this->dateprevulivraison = $dateprevulivraison;

        return $this;
    }

    public function getIsLivre(): ?int
    {
        return $this->isLivre;
    }

    public function setIsLivre(?int $isLivre): self
    {
        $this->isLivre = $isLivre;

        return $this;
    }

    public function __toString(){

            return 'Ref'.$this->refCommande.'CMD2019---Fournisseur: '.$this->userfr;

        }


}
