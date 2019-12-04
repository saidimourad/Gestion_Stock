<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 *  * @UniqueEntity(
 *     fields={"nom_art"},
 *     message="Article existe")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Champ obligatoire")
     */
    private $nom_art;

    /**
     * @Assert\NotBlank(message="Champ obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $unite;

    /**
     *
     *
     * @ORM\Column(name="qte_min", type="float")
     *
     *
     *
        *
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Positive(message="quantité invalide")
     * @Assert\Length(
     *      min = 1,
     *      max = 100,
     *      minMessage = "Au moins {{ limit }} characters ",
     *      maxMessage = "Au plus {{ limit }} characters"
     * )
     */
    private $qte_min;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Catégorie de l'Article est obligatoire")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detailentree", mappedBy="article" , cascade={"remove", "persist"})
     */
    private $detailentrees;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detailsortie", mappedBy="article" , cascade={"remove", "persist"})
     */
    private $detailsorties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lingecommande", mappedBy="article" , cascade={"remove", "persist"})
     */
    private $lingecommandes;

    public function __construct()
    {
        $this->detailentrees = new ArrayCollection();
        $this->detailsorties = new ArrayCollection();
        $this->lingecommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomArt(): ?string
    {
        return $this->nom_art;
    }

    public function setNomArt(string $nom_art): self
    {
        $this->nom_art = $nom_art;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): self
    {
        $this->unite = $unite;

        return $this;
    }




    public function getQteMin()
    {
        return $this->qte_min;
    }

    public function setQteMin( $qte_min)
    {
        $this->qte_min = $qte_min;

        return $this;
    }


   /* public function getQteMin(): ?float
    {
        return $this->qte_min;
    }

    public function setQteMin(float $qte_min): self
    {
        $this->qte_min = $qte_min;

        return $this;
    }*/

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

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
            $detailentree->setArticle($this);
        }

        return $this;
    }

    public function removeDetailentree(Detailentree $detailentree): self
    {
        if ($this->detailentrees->contains($detailentree)) {
            $this->detailentrees->removeElement($detailentree);
            // set the owning side to null (unless already changed)
            if ($detailentree->getArticle() === $this) {
                $detailentree->setArticle(null);
            }
        }

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
            $detailsorty->setArticle($this);
        }

        return $this;
    }

    public function removeDetailsorty(Detailsortie $detailsorty): self
    {
        if ($this->detailsorties->contains($detailsorty)) {
            $this->detailsorties->removeElement($detailsorty);
            // set the owning side to null (unless already changed)
            if ($detailsorty->getArticle() === $this) {
                $detailsorty->setArticle(null);
            }
        }

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
            $lingecommande->setArticle($this);
        }

        return $this;
    }

    public function removeLingecommande(Lingecommande $lingecommande): self
    {
        if ($this->lingecommandes->contains($lingecommande)) {
            $this->lingecommandes->removeElement($lingecommande);
            // set the owning side to null (unless already changed)
            if ($lingecommande->getArticle() === $this) {
                $lingecommande->setArticle(null);
            }
        }

        return $this;
    }
}
