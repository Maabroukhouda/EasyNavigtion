<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * @ORM\Entity(repositoryClass="App\Repository\FournisseurRepository")
 * @UniqueEntity(fields={"cin"},message="cin deja utiliser")
 * @UniqueEntity(fields={"numTel"}, message="numero telephone deja utiliser")
 */
class Fournisseur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="bigint",name="cin")
     * @Assert\Positive(
     *     message="Le numero de Carte identite n'est pas valide !"
     * )
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Le numéro de Carte identite doit être composé de 8 chiffres !",
     * )
     */
    private $cin;

    /**
     * @ORM\Column(type="bigint",name="numTel")
     * @Assert\Positive(
     *     message="Le numero de télephne n'est pas valide !"
     * )
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Le numéro de téléphone doit être composé de 8 chiffres !",
     * )
     */
    private $numTel;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="fournisseur", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     *  @Assert\Type(type="App\Entity\user")
     * @Assert\Valid
     */
    private $user;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getnumTel(): ?string
    {
        return $this->numTel;
    }

    public function setnumTel(string $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
