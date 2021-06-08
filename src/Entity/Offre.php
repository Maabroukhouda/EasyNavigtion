<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=App\Repository\OffreRepository::class)
 */

class Offre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\ManyToOne(targetEntity=OffreType::class, inversedBy="offre")
     * @ORM\JoinColumn(nullable=false)
   
     */
    private $offreType;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="offres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=VoyageRegulier::class, mappedBy="offre", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="offre_vr")
     */
    private $voyageRegulier;

    /**
     * @ORM\OneToOne(targetEntity=VoyageOrganiser::class, mappedBy="offre", cascade={"persist", "remove"})
     *  @ORM\JoinTable(name="offre_vo")
     */
    private $voyageOrganiser;

    /**
     * @ORM\OneToOne(targetEntity=MoyenneTransport::class, mappedBy="offre", cascade={"persist", "remove"})
     *  @ORM\JoinTable(name="offre_mt")
     *  @Assert\Type(type="App\Entity\MoyenneTransport")
     * @Assert\Valid
     */
    private $moyenneTransport;

    /**
     * @ORM\OneToOne(targetEntity=Location::class, mappedBy="offre", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="offre_l")

     */
    private $location;

    /**
     * @ORM\Column(type="float" , name="prix")
     * @Assert\Range(
     *      min =1,
     *      minMessage = "le prix n'est pas valide !",
     * )
     */
    private $prix;

    /**
     * @ORM\Column(type="integer" , name="nbplace")
     * @Assert\Range(
     *      min =1,
     *      minMessage = "le nombre de place n'est pas valide !",
     * )
     */
    private $nbplace;

    /**
     * @ORM\ManyToMany(targetEntity=Parcs::class, mappedBy="offre")
     */
    private $parcs;

    public function __construct()
    {
        $this->parcs = new ArrayCollection();
    }

    ///**
    //* @ORM\Column(type="datetime")
    //*/
    //private $CreatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffreType(): ?OffreType
    {
        return $this->offreType;
    }

    public function setOffreType(?OffreType $offreType): self
    {
        $this->offreType = $offreType;

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

    public function getVoyageRegulier(): ?VoyageRegulier
    {
        return $this->voyageRegulier;
    }

    public function setVoyageRegulier(?VoyageRegulier $voyageRegulier): self
    {
        // unset the owning side of the relation if necessary
        if ($voyageRegulier === null && $this->voyageRegulier !== null) {
            $this->voyageRegulier->setOffre(null);
        }

        // set the owning side of the relation if necessary
        if ($voyageRegulier !== null && $voyageRegulier->getOffre() !== $this) {
            $voyageRegulier->setOffre($this);
        }

        $this->voyageRegulier = $voyageRegulier;

        return $this;
    }

    public function getVoyageOrganiser(): ?VoyageOrganiser
    {
        return $this->voyageOrganiser;
    }

    public function setVoyageOrganiser(VoyageOrganiser $voyageOrganiser): self
    {
        // set the owning side of the relation if necessary
        if ($voyageOrganiser->getOffre() !== $this) {
            $voyageOrganiser->setOffre($this);
        }

        $this->voyageOrganiser = $voyageOrganiser;

        return $this;
    }


    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): self
    {
        // set the owning side of the relation if necessary
        if ($location->getOffre() !== $this) {
            $location->setOffre($this);
        }

        $this->location = $location;

        return $this;
    }

    public function getMoyenneTransport(): ?MoyenneTransport
    {
        return $this->moyenneTransport;
    }

    public function setMoyenneTransport(MoyenneTransport $moyenneTransport): self
    {
        // set the owning side of the relation if necessary
        if ($moyenneTransport->getOffre() !== $this) {
            $moyenneTransport->setOffret($this);
        }

        $this->moyenneTransport = $moyenneTransport;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /* public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }*/

    public function getNbplace(): ?int
    {
        return $this->nbplace;
    }

    public function setNbplace(int $nbplace): self
    {
        $this->nbplace = $nbplace;

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
            $parc->addOffre($this);
        }

        return $this;
    }

    public function removeParc(Parcs $parc): self
    {
        if ($this->parcs->removeElement($parc)) {
            $parc->removeOffre($this);
        }

        return $this;
    }
}
