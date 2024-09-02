<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, DetailProduit>
     */
    #[ORM\OneToMany(targetEntity: DetailProduit::class, mappedBy: 'genre')]
    private Collection $detailProduits;

    public function __construct()
    {
        $this->detailProduits = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, DetailProduit>
     */
    public function getDetailProduits(): Collection
    {
        return $this->detailProduits;
    }

    public function addDetailProduit(DetailProduit $detailProduit): static
    {
        if (!$this->detailProduits->contains($detailProduit)) {
            $this->detailProduits->add($detailProduit);
            $detailProduit->setGenre($this);
        }

        return $this;
    }

    public function removeDetailProduit(DetailProduit $detailProduit): static
    {
        if ($this->detailProduits->removeElement($detailProduit)) {
            // set the owning side to null (unless already changed)
            if ($detailProduit->getGenre() === $this) {
                $detailProduit->setGenre(null);
            }
        }

        return $this;
    }
}
