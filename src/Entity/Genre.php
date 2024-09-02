<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomGenre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomGenre(): ?string
    {
        return $this->nomGenre;
    }

    public function setNomGenre(string $nomGenre): static
    {
        $this->nomGenre = $nomGenre;

        return $this;
    }
}
