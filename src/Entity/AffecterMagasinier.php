<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\AffecterMagasinierRepository")
 * @UniqueEntity(
 *     fields={"user", "anneeScolaire", "magasin" },
 *    message="Utilisateur Affecté à cette magasin."
 * )
 *
 *  @UniqueEntity(
 *     fields={"user", "anneeScolaire" },
 *    message="Utilisateur Affecté à un magasin."
 * )
 *
 */
class AffecterMagasinier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AnneeScolaire", inversedBy="affectermagasinies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $anneeScolaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Magasin", inversedBy="affectermagasiniers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $magasin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="affectermagasiniers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
