<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LingecommandeRepository")
 */
class Lingecommande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $qtecommande;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="lingecommandes")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="lingecommandes")
     */
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQtecommande(): ?float
    {
        return $this->qtecommande;
    }

    public function setQtecommande(float $qtecommande): self
    {
        $this->qtecommande = $qtecommande;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

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
