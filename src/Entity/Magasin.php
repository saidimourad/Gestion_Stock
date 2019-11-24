<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MagasinRepository")
 * @UniqueEntity(
 *     fields={"designation"},
 *    message="Magasin Existe.")
 */
class Magasin
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
     */
    private $designation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="magasins")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AffecterMagasinier", mappedBy="magasin")
     */
    private $affectermagasiniers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entree", mappedBy="magasin")
     */
    private $entrees;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="magasin")
     */
    private $sorties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="magasin")
     */
    private $commandes;

    public function __construct()
    {
        $this->affectermagasiniers = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection|AffecterMagasinier[]
     */
    public function getAffectermagasiniers(): Collection
    {
        return $this->affectermagasiniers;
    }

    public function addAffectermagasinier(AffecterMagasinier $affectermagasinier): self
    {
        if (!$this->affectermagasiniers->contains($affectermagasinier)) {
            $this->affectermagasiniers[] = $affectermagasinier;
            $affectermagasinier->setMagasin($this);
        }

        return $this;
    }

    public function removeAffectermagasinier(AffecterMagasinier $affectermagasinier): self
    {
        if ($this->affectermagasiniers->contains($affectermagasinier)) {
            $this->affectermagasiniers->removeElement($affectermagasinier);
            // set the owning side to null (unless already changed)
            if ($affectermagasinier->getMagasin() === $this) {
                $affectermagasinier->setMagasin(null);
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
            $entree->setMagasin($this);
        }

        return $this;
    }

    public function removeEntree(Entree $entree): self
    {
        if ($this->entrees->contains($entree)) {
            $this->entrees->removeElement($entree);
            // set the owning side to null (unless already changed)
            if ($entree->getMagasin() === $this) {
                $entree->setMagasin(null);
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
            $sorty->setMagasin($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): self
    {
        if ($this->sorties->contains($sorty)) {
            $this->sorties->removeElement($sorty);
            // set the owning side to null (unless already changed)
            if ($sorty->getMagasin() === $this) {
                $sorty->setMagasin(null);
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
            $commande->setMagasin($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getMagasin() === $this) {
                $commande->setMagasin(null);
            }
        }

        return $this;
    }

/*   public function __toString(){

            return $this->designation;

    }*/
}
