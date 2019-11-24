<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 *  @UniqueEntity(
 *     fields={"email"},
 *     message="email existe")
 * @UniqueEntity(
 *     fields={"cin"},
 *     message="CIN existe")
 * @UniqueEntity(
 *     fields={"mfste"},
 *     message="Matricule existe")
 */

class User implements UserInterface 
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_DIRECTEUR = 'ROLE_DIRECTEUR';
    public const ROLE_FOURNISSEUR = 'ROLE_FOURNISSEUR';
    public const ROLE_CHEFBUREAU = 'ROLE_CHEFBUREAU';
    public const ROLE_CHEFUNITE = 'ROLE_CHEFUNITE';
    public const ROLE_MAGASINIER = 'ROLE_MAGASINIER';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *   @Assert\Email(
     *     message = "Cette email '{{ value }}' n'est pas valide.",
     *     checkMX = true
     * )
     *@Assert\NotBlank
     */
    private $email;

    /**
     *
     * @ORM\Column(type="array")
     *
     */
    private $roles = [];


    /**
     *@Assert\NotBlank(message="le mot de passe est obligatoire")
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 8,
     *      max = 1000,
     *      minMessage = "votre mot de passe au moins {{ limit }} caracters long",
     *      maxMessage = "votre mot de passe au max  {{ limit }} caracters")
     * @Assert\EqualTo(propertyPath="confirm_password" , message="votre mot de passe doit être  le meme")
     *
     */
    private $password;

    /**
     * @Assert\NotBlank(message="Confirmation est obligatoire")
     * @Assert\Length(
     *      min = 8,
     *      max = 1000,
     *      minMessage = "votre mot de passe au moins {{ limit }} caracters ",
     *      maxMessage = "votre mot de passe au max  {{ limit }} characters")
     * @Assert\EqualTo(propertyPath="password" , message="votre mot de passe doit etre le meme")
     */


    public  $confirm_password;


    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirm_password;
    }

    /**
     * @param mixed $confirm_password
     */
    public function setConfirmPassword($confirm_password): void
    {
        $this->confirm_password = $confirm_password;
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomste;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gerantste;

    /**
     * @ORM\Column(type="date", nullable=true)
     *  @Assert\Date
     */
    private $datenassance;

    /**
     * @ORM\Column(type="date", nullable=true)
     *  @Assert\Date
     */
    private $datecreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activiteste;

 

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mfste;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AffecterMagasinier", mappedBy="user" , cascade={"remove", "persist"})
     */
    private $affectermagasiniers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AffecterChefbureau", mappedBy="user" , cascade={"remove", "persist"})
     */
    private $affecterchb;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AffecterChefunite", mappedBy="user" , cascade={"remove", "persist"})
     */
    private $affecterchefunite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="userfr" , cascade={"remove", "persist"})
     */
    private $fournisseurs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="userchb" , cascade={"remove", "persist"})
     */
    private $chefbureau;



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entree", mappedBy="entuser" , cascade={"remove", "persist"})
     */
    private $entreesuser;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="user" , cascade={"remove", "persist"})
     */
    private $sortuser;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="userchu" , cascade={"remove", "persist"})
     */
    private $chefunite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etatcivil;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateembauche;



    public function __construct()
    {
        $this->affectermagasiniers = new ArrayCollection();
        $this->affecterchb = new ArrayCollection();
        $this->affecterchefunite = new ArrayCollection();
        $this->fournisseurs = new ArrayCollection();
        $this->chefbureau = new ArrayCollection();
        $this->entreesfr = new ArrayCollection();
        $this->entreesuser = new ArrayCollection();
        $this->sortuser = new ArrayCollection();
        $this->chefunite = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
       // $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */



    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getPassword()
    {
        return $this->password;
    }



 /*   public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }*/

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(?string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getNomste(): ?string
    {
        return $this->nomste;
    }

    public function setNomste(?string $nomste): self
    {
        $this->nomste = $nomste;

        return $this;
    }

    public function getGerantste(): ?string
    {
        return $this->gerantste;
    }

    public function setGerantste(?string $gerantste): self
    {
        $this->gerantste = $gerantste;

        return $this;
    }

    public function getDatenassance(): ?\DateTimeInterface
    {
        return $this->datenassance;
    }

    public function setDatenassance(?\DateTimeInterface $datenassance): self
    {
        $this->datenassance = $datenassance;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(?\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getActiviteste(): ?string
    {
        return $this->activiteste;
    }

    public function setActiviteste(string $activiteste): self
    {
        $this->activiteste = $activiteste;

        return $this;
    }



    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getMfste(): ?string
    {
        return $this->mfste;
    }

    public function setMfste(?string $mfste): self
    {
        $this->mfste = $mfste;

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
            $affectermagasinier->setUser($this);
        }

        return $this;
    }

    public function removeAffectermagasinier(AffecterMagasinier $affectermagasinier): self
    {
        if ($this->affectermagasiniers->contains($affectermagasinier)) {
            $this->affectermagasiniers->removeElement($affectermagasinier);
            // set the owning side to null (unless already changed)
            if ($affectermagasinier->getUser() === $this) {
                $affectermagasinier->setUser(null);
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
            $affecterchb->setUser($this);
        }

        return $this;
    }

    public function removeAffecterchb(AffecterChefbureau $affecterchb): self
    {
        if ($this->affecterchb->contains($affecterchb)) {
            $this->affecterchb->removeElement($affecterchb);
            // set the owning side to null (unless already changed)
            if ($affecterchb->getUser() === $this) {
                $affecterchb->setUser(null);
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
            $affecterchefunite->setUser($this);
        }

        return $this;
    }

    public function removeAffecterchefunite(AffecterChefunite $affecterchefunite): self
    {
        if ($this->affecterchefunite->contains($affecterchefunite)) {
            $this->affecterchefunite->removeElement($affecterchefunite);
            // set the owning side to null (unless already changed)
            if ($affecterchefunite->getUser() === $this) {
                $affecterchefunite->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getFournisseurs(): Collection
    {
        return $this->fournisseurs;
    }

    public function addFournisseur(Commande $fournisseur): self
    {
        if (!$this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs[] = $fournisseur;
            $fournisseur->setUserfr($this);
        }

        return $this;
    }

    public function removeFournisseur(Commande $fournisseur): self
    {
        if ($this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs->removeElement($fournisseur);
            // set the owning side to null (unless already changed)
            if ($fournisseur->getUserfr() === $this) {
                $fournisseur->setUserfr(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getChefbureau(): Collection
    {
        return $this->chefbureau;
    }

    public function addChefbureau(Commande $chefbureau): self
    {
        if (!$this->chefbureau->contains($chefbureau)) {
            $this->chefbureau[] = $chefbureau;
            $chefbureau->setUserchb($this);
        }

        return $this;
    }

    public function removeChefbureau(Commande $chefbureau): self
    {
        if ($this->chefbureau->contains($chefbureau)) {
            $this->chefbureau->removeElement($chefbureau);
            // set the owning side to null (unless already changed)
            if ($chefbureau->getUserchb() === $this) {
                $chefbureau->setUserchb(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Entree[]
     */
    public function getEntreesuser(): Collection
    {
        return $this->entreesuser;
    }

    public function addEntreesuser(Entree $entreesuser): self
    {
        if (!$this->entreesuser->contains($entreesuser)) {
            $this->entreesuser[] = $entreesuser;
            $entreesuser->setEntuser($this);
        }

        return $this;
    }

    public function removeEntreesuser(Entree $entreesuser): self
    {
        if ($this->entreesuser->contains($entreesuser)) {
            $this->entreesuser->removeElement($entreesuser);
            // set the owning side to null (unless already changed)
            if ($entreesuser->getEntuser() === $this) {
                $entreesuser->setEntuser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getSortuser(): Collection
    {
        return $this->sortuser;
    }

    public function addSortuser(Sortie $sortuser): self
    {
        if (!$this->sortuser->contains($sortuser)) {
            $this->sortuser[] = $sortuser;
            $sortuser->setUser($this);
        }

        return $this;
    }

    public function removeSortuser(Sortie $sortuser): self
    {
        if ($this->sortuser->contains($sortuser)) {
            $this->sortuser->removeElement($sortuser);
            // set the owning side to null (unless already changed)
            if ($sortuser->getUser() === $this) {
                $sortuser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getChefunite(): Collection
    {
        return $this->chefunite;
    }

    public function addChefunite(Commande $chefunite): self
    {
        if (!$this->chefunite->contains($chefunite)) {
            $this->chefunite[] = $chefunite;
            $chefunite->setUserchu($this);
        }

        return $this;
    }

    public function removeChefunite(Commande $chefunite): self
    {
        if ($this->chefunite->contains($chefunite)) {
            $this->chefunite->removeElement($chefunite);
            // set the owning side to null (unless already changed)
            if ($chefunite->getUserchu() === $this) {
                $chefunite->setUserchu(null);
            }
        }

        return $this;
    }


    public function __toString(){
        if($this->nomste==null)
        {
        return $this->nom.'   '.$this->prenom.'--CIN: '.$this->cin.'--Email:  '.$this->email;
        }
        if($this->cin==null)
        {
            return $this->nomste.'--MF:'.$this->mfste.'--Email:'.$this->email;

        }
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getEtatcivil(): ?string
    {
        return $this->etatcivil;
    }

    public function setEtatcivil(?string $etatcivil): self
    {
        $this->etatcivil = $etatcivil;

        return $this;
    }

    public function getDateembauche(): ?\DateTimeInterface
    {
        return $this->dateembauche;
    }

    public function setDateembauche(?\DateTimeInterface $dateembauche): self
    {
        $this->dateembauche = $dateembauche;

        return $this;
    }

}
