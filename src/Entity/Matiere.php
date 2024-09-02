<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    /**
     * @var Collection<int, MatiereProduit>
     */
    #[ORM\OneToMany(targetEntity: MatiereProduit::class, mappedBy: 'matiere')]
    private Collection $matiereProduits;

    public function __construct()
    {
        $this->matiereProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, MatiereProduit>
     */
    public function getMatiereProduits(): Collection
    {
        return $this->matiereProduits;
    }

    public function addMatiereProduit(MatiereProduit $matiereProduit): static
    {
        if (!$this->matiereProduits->contains($matiereProduit)) {
            $this->matiereProduits->add($matiereProduit);
            $matiereProduit->setMatiere($this);
        }

        return $this;
    }

    public function removeMatiereProduit(MatiereProduit $matiereProduit): static
    {
        if ($this->matiereProduits->removeElement($matiereProduit)) {
            // set the owning side to null (unless already changed)
            if ($matiereProduit->getMatiere() === $this) {
                $matiereProduit->setMatiere(null);
            }
        }

        return $this;
    }
}
