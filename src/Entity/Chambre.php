<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(nullable: true)]
    private ?int $capaciteAdulte = null;

    #[ORM\Column(nullable: true)]
    private ?int $capaciteEnfant = null;

    #[ORM\Column(nullable: true)]
    private ?bool $statut = null;

    

    #[ORM\ManyToOne(inversedBy: 'chambres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeDeChambre $typeDeChambre = null;

    /**
     * @var Collection<int, Images>
     */
    #[ORM\OneToMany(targetEntity: Images::class, mappedBy: 'chambre', cascade: ["persist","remove"])]
    private Collection $images;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $prix = null;

    

    #[ORM\Column(nullable: true)]
    private ?int $lits = null;

    #[ORM\Column(nullable: true)]
    private ?int $sallesDeBain = null;

    /**
     * @var Collection<int, Service>
     */
    #[ORM\ManyToMany(targetEntity: Service::class, inversedBy: 'chambres')]
    private Collection $services;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'chambre', orphanRemoval: true)]
    private Collection $commentaires;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        
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
    public function __toString()
    {
        return $this->numero;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    

    

    
    

    public function getLits(): ?int
    {
        return $this->lits;
    }

    public function setLits(?int $lits): static
    {
        $this->lits = $lits;

        return $this;
    }

    public function getSallesDeBain(): ?int
    {
        return $this->sallesDeBain;
    }

    public function setSallesDeBain(?int $sallesDeBain): static
    {
        $this->sallesDeBain = $sallesDeBain;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        $this->services->removeElement($service);

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setChambre($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getChambre() === $this) {
                $commentaire->setChambre(null);
            }
        }

        return $this;
    }
}