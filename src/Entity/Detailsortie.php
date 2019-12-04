<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DetailsortieRepository")
 */
class Detailsortie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="detailsorties")
     * @Assert\NotBlank(message="champ obligatoire")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sortie", inversedBy="detailsorties")
     *
     */
    private $sortie;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="champ obligatoire")
     */
    private $qtesortie;

    public  $message;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSortie(): ?Sortie
    {
        return $this->sortie;
    }

    public function setSortie(?Sortie $sortie): self
    {
        $this->sortie = $sortie;

        return $this;
    }

    public function getQtesortie(): ?float
    {
        return $this->qtesortie;
    }

    public function setQtesortie(float $qtesortie): self
    {
        $this->qtesortie = $qtesortie;

        return $this;
    }



}
