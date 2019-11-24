<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
  * @UniqueEntity(
 *     fields={"designation"},
 *     message="Région existe")
 */
class Region
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Champ région obligatoire")

     */
    private $designation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Magasin", mappedBy="region")
     */
    private $magasins;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AffecterChefbureau", mappedBy="region")
     */
    private $affecterchb;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AffecterChefunite", mappedBy="region")
     */
    private $affecterchefunite;

    public function __construct()
    {
        $this->magasins = new ArrayCollection();
        $this->affecterchb = new ArrayCollection();
        $this->affecterchefunite = new ArrayCollection();
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

    /**
     * @return Collection|Magasin[]
     */
    public function getMagasins(): Collection
    {
        return $this->magasins;
    }

    public function addMagasin(Magasin $magasin): self
    {
        if (!$this->magasins->contains($magasin)) {
            $this->magasins[] = $magasin;
            $magasin->setRegion($this);
        }

        return $this;
    }

    public function removeMagasin(Magasin $magasin): self
    {
        if ($this->magasins->contains($magasin)) {
            $this->magasins->removeElement($magasin);
            // set the owning side to null (unless already changed)
            if ($magasin->getRegion() === $this) {
                $magasin->setRegion(null);
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
            $affecterchb->setRegion($this);
        }

        return $this;
    }

    public function removeAffecterchb(AffecterChefbureau $affecterchb): self
    {
        if ($this->affecterchb->contains($affecterchb)) {
            $this->affecterchb->removeElement($affecterchb);
            // set the owning side to null (unless already changed)
            if ($affecterchb->getRegion() === $this) {
                $affecterchb->setRegion(null);
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
            $affecterchefunite->setRegion($this);
        }

        return $this;
    }

    public function removeAffecterchefunite(AffecterChefunite $affecterchefunite): self
    {
        if ($this->affecterchefunite->contains($affecterchefunite)) {
            $this->affecterchefunite->removeElement($affecterchefunite);
            // set the owning side to null (unless already changed)
            if ($affecterchefunite->getRegion() === $this) {
                $affecterchefunite->setRegion(null);
            }
        }

        return $this;
    }
}
