<?php

namespace App\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnneeScolaireRepository")
 * @UniqueEntity(
 *     fields={"designation" },
 *    message="Anneé Existe."
 * )
 */
class AnneeScolaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Positive(message="Année invalide")
     * @Assert\Length(
     *      min = 4,
     *      max = 7,
     *      minMessage = "Au moins {{ limit }} characters ",
     *      maxMessage = "Au plus {{ limit }} characters"
     * )
     */
    private $designation;

    /**
     * @ORM\Column(type="integer")
     */
    private $actif;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    private $encours;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AffecterMagasinier", mappedBy="anneeScolaire" , cascade={"remove", "persist"})
     */
    private $affectermagasinies;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AffecterChefbureau", mappedBy="anneeScolaire", cascade={"remove", "persist"})
     */
    private $affecterchb;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AffecterChefunite", mappedBy="anneeScolaire", cascade={"remove", "persist"})
     */
    private $affecterchefunite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entree", mappedBy="anneeScolaire", cascade={"remove", "persist"})
     */
    private $entrees;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="anneeScolaire", cascade={"remove", "persist"})
     */
    private $sorties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="anneeScolaire", cascade={"remove", "persist"})
     */
    private $commandes;

    public function __construct()
    {
        $this->affectermagasinies = new ArrayCollection();
        $this->affecterchb = new ArrayCollection();
        $this->affecterchefunite = new ArrayCollection();
        $this->entrees = new ArrayCollection();
        $this->sorties = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }







    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getActif(): ?int
    {
        return $this->actif;
    }

    public function setActif(int $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getEncours(): ?int
    {
        return $this->encours;
    }

    public function setEncours(?int $encours): self
    {
        $this->encours = $encours;

        return $this;
    }

    /**
     * @return Collection|AffecterMagasinier[]
     */
    public function getAffectermagasinies(): Collection
    {
        return $this->affectermagasinies;
    }

    public function addAffectermagasiny(AffecterMagasinier $affectermagasiny): self
    {
        if (!$this->affectermagasinies->contains($affectermagasiny)) {
            $this->affectermagasinies[] = $affectermagasiny;
            $affectermagasiny->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeAffectermagasiny(AffecterMagasinier $affectermagasiny): self
    {
        if ($this->affectermagasinies->contains($affectermagasiny)) {
            $this->affectermagasinies->removeElement($affectermagasiny);
            // set the owning side to null (unless already changed)
            if ($affectermagasiny->getAnneeScolaire() === $this) {
                $affectermagasiny->setAnneeScolaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AffecterChefbureau[]
     */
    public function getAffecterchb(): Collection
    {
        return $this->affecterchb;
    }

    public function addAffecterchb(AffecterChefbureau $affecterchb): self
    {
        if (!$this->affecterchb->contains($affecterchb)) {
            $this->affecterchb[] = $affecterchb;
            $affecterchb->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeAffecterchb(AffecterChefbureau $affecterchb): self
    {
        if ($this->affecterchb->contains($affecterchb)) {
            $this->affecterchb->removeElement($affecterchb);
            // set the owning side to null (unless already changed)
            if ($affecterchb->getAnneeScolaire() === $this) {
                $affecterchb->setAnneeScolaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AffecterChefunite[]
     */
    public function getAffecterchefunite(): Collection
    {
        return $this->affecterchefunite;
    }

    public function addAffecterchefunite(AffecterChefunite $affecterchefunite): self
    {
        if (!$this->affecterchefunite->contains($affecterchefunite)) {
            $this->affecterchefunite[] = $affecterchefunite;
            $affecterchefunite->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeAffecterchefunite(AffecterChefunite $affecterchefunite): self
    {
        if ($this->affecterchefunite->contains($affecterchefunite)) {
            $this->affecterchefunite->removeElement($affecterchefunite);
            // set the owning side to null (unless already changed)
            if ($affecterchefunite->getAnneeScolaire() === $this) {
                $affecterchefunite->setAnneeScolaire(null);
            }
        }

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
            $entree->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeEntree(Entree $entree): self
    {
        if ($this->entrees->contains($entree)) {
            $this->entrees->removeElement($entree);
            // set the owning side to null (unless already changed)
            if ($entree->getAnneeScolaire() === $this) {
                $entree->setAnneeScolaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortie $sorty): self
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties[] = $sorty;
            $sorty->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): self
    {
        if ($this->sorties->contains($sorty)) {
            $this->sorties->removeElement($sorty);
            // set the owning side to null (unless already changed)
            if ($sorty->getAnneeScolaire() === $this) {
                $sorty->setAnneeScolaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setAnneeScolaire($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getAnneeScolaire() === $this) {
                $commande->setAnneeScolaire(null);
            }
        }

        return $this;
    }






}
