<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChambreRepository::class)]
class Chambre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\Column]
    private ?int $capaciteAdulte = null;

    #[ORM\Column]
    private ?int $capaciteEnfant = null;

    #[ORM\Column(nullable: true)]
    private ?bool $statut = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'chambres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeDeChambre $typeDeChambre = null;

    /**
     * @var Collection<int, Images>
     */
    #[ORM\OneToMany(targetEntity: Images::class, mappedBy: 'chambre')]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCapaciteAdulte(): ?int
    {
        return $this->capaciteAdulte;
    }

    public function setCapaciteAdulte(int $capaciteAdulte): static
    {
        $this->capaciteAdulte = $capaciteAdulte;

        return $this;
    }

    public function getCapaciteEnfant(): ?int
    {
        return $this->capaciteEnfant;
    }

    public function setCapaciteEnfant(int $capaciteEnfant): static
    {
        $this->capaciteEnfant = $capaciteEnfant;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTypeDeChambre(): ?TypeDeChambre
    {
        return $this->typeDeChambre;
    }

    public function setTypeDeChambre(?TypeDeChambre $typeDeChambre): static
    {
        $this->typeDeChambre = $typeDeChambre;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setChambre($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getChambre() === $this) {
                $image->setChambre(null);
            }
        }

        return $this;
    }
}
