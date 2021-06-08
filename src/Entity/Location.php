<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Offre::class, inversedBy="location", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $offre;

    /**
     * @ORM\ManyToOne(targetEntity=Parcs::class, inversedBy="offre_location")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parcs;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(Offre $offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    public function getParcs(): ?Parcs
    {
        return $this->parcs;
    }

    public function setParcs(?Parcs $parcs): self
    {
        $this->parcs = $parcs;

        return $this;
    }
}
