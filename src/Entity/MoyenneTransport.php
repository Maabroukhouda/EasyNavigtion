<?php

namespace App\Entity;

use App\Repository\MoyenneTransportRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=MoyenneTransportRepository::class)
 */
class MoyenneTransport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "la Marque doit être composé de 3 lettres minimum !",
     *      maxMessage = "la Marque est tres long"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length( min = 1,
     *      minMessage = "l'image ne doit pas être nulle. !",
     * )
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     *  @Assert\Length( min = 3, max = 250,
     *      minMessage = "description est tres court",
     *      maxMessage = "location est tres long"
     * )
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity=Offre::class, inversedBy="moyenneTransport", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $offre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffret(Offre $offre): self
    {
        $this->offre = $offre;

        return $this;
    }
}
