<?php

namespace App\Entity;

use App\Repository\TailleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
class Taille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $taille = null;

    /**
     * @var Collection<int, DetailProduit>
     */
    #[ORM\OneToMany(targetEntity: DetailProduit::class, mappedBy: 'taille')]
    private Collection $detailProduits;

    public function __construct()
    {
        $this->detailProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): static
    {
        $this->taille = $taille;

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
            $detailProduit->setTaille($this);
        }

        return $this;
    }

    public function removeDetailProduit(DetailProduit $detailProduit): static
    {
        if ($this->detailProduits->removeElement($detailProduit)) {
            // set the owning side to null (unless already changed)
            if ($detailProduit->getTaille() === $this) {
                $detailProduit->setTaille(null);
            }
        }

        return $this;
    }
}
