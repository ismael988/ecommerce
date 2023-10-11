<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'produit')]
    private ?User $use = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Panier::class)]
    private Collection $commande;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function __construct()
    {
        $this->commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getUse(): ?User
    {
        return $this->use;
    }

    public function setUse(?User $use): static
    {
        $this->use = $use;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Panier $commande): static
    {
        if (!$this->commande->contains($commande)) {
            $this->commande->add($commande);
            $commande->setProduit($this);
        }

        return $this;
    }

    public function removeCommande(Panier $commande): static
    {
        if ($this->commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getProduit() === $this) {
                $commande->setProduit(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
