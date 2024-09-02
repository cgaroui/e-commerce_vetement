<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomDestinataire = null;

    #[ORM\Column(length: 255)]
    private ?string $choixLivraison = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDestinataire(): ?string
    {
        return $this->nomDestinataire;
    }

    public function setNomDestinataire(string $nomDestinataire): static
    {
        $this->nomDestinataire = $nomDestinataire;

        return $this;
    }

    public function getChoixLivraison(): ?string
    {
        return $this->choixLivraison;
    }

    public function setChoixLivraison(string $choixLivraison): static
    {
        $this->choixLivraison = $choixLivraison;

        return $this;
    }
}
