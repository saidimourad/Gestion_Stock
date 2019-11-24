<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DetailentreeRepository")
 */
class Detailentree
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**

     * @ORM\Column(type="float")
     * @Assert\Type(
     *     type="float",
     *     message="La valeur {{ value }} n'est pas valide {{ type }}."
     * )
     *
     * @Assert\NotBlank
     * @Assert\Positive
     * @Assert\Length(
     *      min = 1,
     *      max = 10,
     *      minMessage = "Au moins {{ limit }} characters ",
     *      maxMessage = "Au plus {{ limit }} characters"
     * )
     *
     */
    private $qteentree;

    /**
     * @ORM\Column(type="float")
     *@Assert\NotBlank
     *
     * @Assert\Length(
     *      min = 1,
     *      max = 10,
     *      minMessage = "Au moins {{ limit }} characters ",
     *      maxMessage = "Au plus {{ limit }} characters"
     * )
     * @Assert\Type(
     *     type="float",
     *     message="La valeur {{ value }} n'est pas valide {{ type }}."
     * )
     */
    private $prixentree;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="detailentrees")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entree", inversedBy="detailentrees")
     */
    private $entree;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQteentree(): ?float
    {
        return $this->qteentree;
    }

    public function setQteentree(float $qteentree): self
    {
        $this->qteentree = $qteentree;

        return $this;
    }

    public function getPrixentree(): ?float
    {
        return $this->prixentree;
    }

    public function setPrixentree(float $prixentree): self
    {
        $this->prixentree = $prixentree;

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

    public function getEntree(): ?Entree
    {
        return $this->entree;
    }

    public function setEntree(?Entree $entree): self
    {
        $this->entree = $entree;

        return $this;
    }
}
