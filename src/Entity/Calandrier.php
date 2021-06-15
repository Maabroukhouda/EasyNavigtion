<?php

namespace App\Entity;

use App\Repository\CalandrierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CalandrierRepository::class)
 */
class Calandrier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=VoyageRegulier::class, inversedBy="calandries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $voyageRegulier;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getVoyageRegulier(): ?VoyageRegulier
    {
        return $this->voyageRegulier;
    }

    public function setVoyageRegulier(?VoyageRegulier $voyageRegulier): self
    {
        $this->voyageRegulier = $voyageRegulier;

        return $this;
    }


}
