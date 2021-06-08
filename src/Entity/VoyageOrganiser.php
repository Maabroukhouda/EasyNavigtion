<?php

namespace App\Entity;

use App\Repository\VoyageOrganiserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VoyageOrganiserRepository::class)
 */
class VoyageOrganiser
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
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today" ,message="La data non valide ")
     */

    private $datee;



    /**
     * @ORM\OneToOne(targetEntity=Offre::class, inversedBy="voyageOrganiser", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
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



    public function getDatee(): ?\DateTimeInterface
    {
        return $this->datee;
    }

    public function setDatee(\DateTimeInterface $datee): self
    {
        $this->datee = $datee;

        return $this;
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
}
