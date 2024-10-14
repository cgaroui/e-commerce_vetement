<?php

namespace App\Entity;

use App\Repository\PanierArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierArticleRepository::class)]
class PanierArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $produit = null;

    #[ORM\Column]
    private ?int $quantite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    //cette fonction permet de s'assurer qu'il n'ya pas de doublon, qu'un article ne soit pas ajouté au panier 2 fois grace à son id 
    public function equals(PanierArticle $article) : bool
    {
        return $this->getProduit()->getId() === $article->getProduit()->getId();
    }
}
