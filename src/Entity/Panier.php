<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameProduit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $pricePanier = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?Produit $produit = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?Commande $commande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameProduit(): ?string
    {
        return $this->nameProduit;
    }

    public function setNameProduit(string $nameProduit): self
    {
        $this->nameProduit = $nameProduit;
        return $this;
    }

    public function getPricePanier(): ?string
    {
        return $this->pricePanier;
    }

    public function setPricePanier(string $pricePanier): self
    {
        $this->pricePanier = $pricePanier;
        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;
        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;
        return $this;
    }
}
