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
     * @ORM\ManyToOne(targetEntity=VoyageRegulier::class, inversedBy="calandriers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $regulier;

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

    public function getRegulier(): ?VoyageRegulier
    {
        return $this->regulier;
    }

    public function setRegulier(?VoyageRegulier $regulier): self
    {
        $this->regulier = $regulier;

        return $this;
    }
}
