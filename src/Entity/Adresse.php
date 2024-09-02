<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 50)]
    private ?string $cp = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\ManyToOne(inversedBy: 'Adresse')]
    private ?AdresseClient $adresseClient = null;

    /**
     * @var Collection<int, AdresseClient>
     */
    #[ORM\OneToMany(targetEntity: AdresseClient::class, mappedBy: 'adresse')]
    private Collection $adresseClients;

    public function __construct()
    {
        $this->adresseClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): static
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAdresseClient(): ?AdresseClient
    {
        return $this->adresseClient;
    }

    public function setAdresseClient(?AdresseClient $adresseClient): static
    {
        $this->adresseClient = $adresseClient;

        return $this;
    }

    /**
     * @return Collection<int, AdresseClient>
     */
    public function getAdresseClients(): Collection
    {
        return $this->adresseClients;
    }

    public function addAdresseClient(AdresseClient $adresseClient): static
    {
        if (!$this->adresseClients->contains($adresseClient)) {
            $this->adresseClients->add($adresseClient);
            $adresseClient->setAdresse($this);
        }

        return $this;
    }

    public function removeAdresseClient(AdresseClient $adresseClient): static
    {
        if ($this->adresseClients->removeElement($adresseClient)) {
            // set the owning side to null (unless already changed)
            if ($adresseClient->getAdresse() === $this) {
                $adresseClient->setAdresse(null);
            }
        }

        return $this;
    }
}
