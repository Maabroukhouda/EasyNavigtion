<?php

namespace App\Entity;

use App\Repository\ParcsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParcsRepository::class)
 */
class Parcs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="point")
     */
    private $location;

    /**
     * @ORM\ManyToMany(targetEntity=Offre::class, inversedBy="parcs")
     */
    private $offre;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="parcs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="parcs")
     */
    private $offre_location;

    public function __construct()
    {
        $this->offre = new ArrayCollection();
        $this->offre_location = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection|Offre[]
     */
    public function getOffre(): Collection
    {
        return $this->offre;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offre->contains($offre)) {
            $this->offre[] = $offre;
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        $this->offre->removeElement($offre);

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
     * @return Collection|Location[]
     */
    public function getOffreLocation(): Collection
    {
        return $this->offre_location;
    }

    public function addOffreLocation(Location $offreLocation): self
    {
        if (!$this->offre_location->contains($offreLocation)) {
            $this->offre_location[] = $offreLocation;
            $offreLocation->setParcs($this);
        }

        return $this;
    }

    public function removeOffreLocation(Location $offreLocation): self
    {
        if ($this->offre_location->removeElement($offreLocation)) {
            // set the owning side to null (unless already changed)
            if ($offreLocation->getParcs() === $this) {
                $offreLocation->setParcs(null);
            }
        }
        return $this;
    }
}
