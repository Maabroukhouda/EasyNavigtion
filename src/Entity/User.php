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
 * @UniqueEntity(fields={"Email"},message="L'adresse email deja utiliser")
 */

class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string",name="Email", length=255)
     * @Assert\Email(
     *     message = "L'adresse email n'est past valide."
     * )
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 3, max = 20,
     *      minMessage = "Le nom doit être composé de 3 lettres minimum !",
     *      maxMessage = "Le nom est tres long"
     * ) 
     */
    private $nomUser;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\Length( min = 3, max = 50,
     *      minMessage = "Le Prenom doit être composé de 3 lettres minimum !",
     *      maxMessage = "Le Prenom est tres long"
     * )
     */
    private $Username;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length( min = 8,
     *      minMessage = "Le mot de passe doit être composé de 8 caractères minimum !",
     * )
     */
    private $Password;

    public $oldPassword;

    /**
     * @ORM\ManyToOne(targetEntity=UserType::class, inversedBy="user")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userType;

    /**
     * @ORM\OneToOne(targetEntity=Fournisseur::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $fournisseur;

    /**
     * @ORM\OneToOne(targetEntity=SimpleUser::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $simpleUser;

    /**
     * @ORM\OneToMany(targetEntity=Offre::class, mappedBy="user", orphanRemoval=true)
     */
    private $offres;

    /**
     * @ORM\OneToMany(targetEntity=Parcs::class, mappedBy="user")
     */
    private $parcs;

    public function __construct()
    {
        $this->simpleUsers = new ArrayCollection();
        $this->offres = new ArrayCollection();
        $this->parcs = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }

    public function setNomUser(string $nomUser): self
    {
        $this->nomUser = $nomUser;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): self
    {
        $this->Username = $Username;

        return $this;
    }



    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }
    public function eraseCredentials()
    {
    }
    public function getSalt()
    {
    }
    public function getRoles()
    {
        return ['ROLE_USER'];
    }
    public function getUserType(): ?UserType
    {
        return $this->userType;
    }

    public function setUserType(?UserType $userType): self
    {
        $this->userType = $userType;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(Fournisseur $fournisseur): self
    {
        // set the owning side of the relation if necessary
        if ($fournisseur->getUser() !== $this) {
            $fournisseur->setUser($this);
        }

        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getSimpleUser(): ?SimpleUser
    {
        return $this->simpleUser;
    }

    public function setSimpleUser(?SimpleUser $simpleUser): self
    {
        // unset the owning side of the relation if necessary
        if ($simpleUser === null && $this->simpleUser !== null) {
            $this->simpleUser->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($simpleUser !== null && $simpleUser->getUser() !== $this) {
            $simpleUser->setUser($this);
        }

        $this->simpleUser = $simpleUser;

        return $this;
    }

    /**
     * @return Collection|Offre[]
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres[] = $offre;
            $offre->setUser($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getUser() === $this) {
                $offre->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Parcs[]
     */
    public function getParcs(): Collection
    {
        return $this->parcs;
    }

    public function addParc(Parcs $parc): self
    {
        if (!$this->parcs->contains($parc)) {
            $this->parcs[] = $parc;
            $parc->setUser($this);
        }

        return $this;
    }

    public function removeParc(Parcs $parc): self
    {
        if ($this->parcs->removeElement($parc)) {
            // set the owning side to null (unless already changed)
            if ($parc->getUser() === $this) {
                $parc->setUser(null);
            }
        }

        return $this;
    }
}
