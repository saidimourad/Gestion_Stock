<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\EntreeRepository")
 */
class Entree
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=255)
     *
     */
    private $refEntree;




  


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detailentree", mappedBy="entree", fetch="EXTRA_LAZY",orphanRemoval=true,  cascade={"remove", "persist"})
     * @Assert\Valid()
     *  @Assert\NotBlank(message="Détail entée obligatoire")
     */
    private $detailentrees;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AnneeScolaire", inversedBy="entrees")
     *  @Assert\NotBlank(message="Anneé scolaire obligatoire")
     */
    private $anneeScolaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Magasin", inversedBy="entrees")
     *
     */
    private $magasin;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="entreesuser")
     */
    private $entuser;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $dateEntree;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="entrees")
     */
    private $commande;



    public function __construct()
    {
        $this->detailentrees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefEntree(): ?int
    {
        return $this->refEntree;
    }

    public function setRefEntree(int $refEntree): self
    {
        $this->refEntree = $refEntree;

        return $this;
    }




    /**
     * @return Collection|Detailentree[]
     */
    public function getDetailentrees(): Collection
    {
        return $this->detailentrees;
    }

    public function addDetailentree(Detailentree $detailentree): self
    {
        if (!$this->detailentrees->contains($detailentree)) {
            $this->detailentrees[] = $detailentree;
            $detailentree->setEntree($this);
        }

        return $this;
    }

    public function removeDetailentree(Detailentree $detailentree): self
    {
        if ($this->detailentrees->contains($detailentree)) {
            $this->detailentrees->removeElement($detailentree);
            // set the owning side to null (unless already changed)
            if ($detailentree->getEntree() === $this) {
                $detailentree->setEntree(null);
            }
        }

        return $this;
    }




    /**
     * Add detail
     *
     * @param \App\Entity\Detailentree $exp
     *
     * @return User
     */
    public function addExp(\App\Entity\Detailentree $exp)
    {
        $this->detailentrees[] = $exp;
        // setting the current user to the $exp,
        // adapt this to whatever you are trying to achieve
        $exp->setEntree($this);
        return $this;
    }

    /**
     * Remove exp
     *
     * @param \App\Entity\Detailentree $exp
     */
    public function removeExp(\App\Entity\Detailentree $exp)
    {
        $this->detailentrees->removeElement($exp);
    }

    /**
     * Get exp
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExp()
    {
        return $this->detailentrees;
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


    public function getEntuser(): ?User
    {
        return $this->entuser;
    }

    public function setEntuser(?User $entuser): self
    {
        $this->entuser = $entuser;

        return $this;
    }

    public function getDateEntree(): ?\DateTimeInterface
    {
        return $this->dateEntree;
    }

    public function setDateEntree(\DateTimeInterface $dateEntree): self
    {
        $this->dateEntree = $dateEntree;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }



}
