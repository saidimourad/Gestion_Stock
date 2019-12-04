<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\SortieRepository")
 */
class Sortie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $refSortie;

    /**
     * @ORM\Column(type="date")
     */
    private $dateSortie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Repas", inversedBy="sorties")
     */
    private $repas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Magasin", inversedBy="sorties")
     */
    private $magasin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AnneeScolaire", inversedBy="sorties")
     */
    private $anneeScolaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sortuser")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detailsortie", mappedBy="sortie", fetch="EXTRA_LAZY",orphanRemoval=true, cascade={"remove", "persist"})
     * @Assert\Valid()
     * /
     /**  @Assert\NotBlank(message="Détail sortie obligatoire")*/

    private $detailsorties;

    public function __construct()
    {
        $this->detailsorties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefSortie(): ?string
    {
        return $this->refSortie;
    }

    public function setRefSortie(string $refSortie): self
    {
        $this->refSortie = $refSortie;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(\DateTimeInterface $dateSortie): self
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getRepas(): ?Repas
    {
        return $this->repas;
    }

    public function setRepas(?Repas $repas): self
    {
        $this->repas = $repas;

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

    public function getAnneeScolaire(): ?AnneeScolaire
    {
        return $this->anneeScolaire;
    }

    public function setAnneeScolaire(?AnneeScolaire $anneeScolaire): self
    {
        $this->anneeScolaire = $anneeScolaire;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Detailsortie[]
     */
    public function getDetailsorties(): Collection
    {
        return $this->detailsorties;
    }

    public function addDetailsorty(Detailsortie $detailsorty): self
    {
        if (!$this->detailsorties->contains($detailsorty)) {
            $this->detailsorties[] = $detailsorty;
            $detailsorty->setSortie($this);
        }

        return $this;
    }

    public function removeDetailsorty(Detailsortie $detailsorty): self
    {
        if ($this->detailsorties->contains($detailsorty)) {
            $this->detailsorties->removeElement($detailsorty);
            // set the owning side to null (unless already changed)
            if ($detailsorty->getSortie() === $this) {
                $detailsorty->setSortie(null);
            }
        }

        return $this;
    }
}
