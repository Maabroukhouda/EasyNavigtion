<?php

namespace App\Entity;

use App\Repository\VoyageRegulierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=VoyageRegulierRepository::class)
 */
class VoyageRegulier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="point")
     * @Assert\NotBlank(message="Ajouter Votre point de depart et destination")
     */
    private $depart;

    /**
     * @ORM\Column(type="point")
     * @Assert\NotBlank(message="Ajouter Votre point de depart et destination")
     */
    private $destination;


    /**
     * @ORM\OneToOne(targetEntity=Offre::class, inversedBy="voyageRegulier", cascade={"persist", "remove"})
     */
    private $offre;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepart()
    {
        return $this->depart;
    }

    public function setDepart($depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function setDestination($destination): self
    {
        $this->destination = $destination;

        return $this;
    }



    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): self
    {
        $this->offre = $offre;

        return $this;
    }



}
