<?php

namespace App\Entity;

use App\Repository\LikesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikesRepository::class)]
class Likes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    private ?Commentaire $comentaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getComentaire(): ?Commentaire
    {
        return $this->comentaire;
    }

    public function setComentaire(?Commentaire $comentaire): static
    {
        $this->comentaire = $comentaire;

        return $this;
    }
}
