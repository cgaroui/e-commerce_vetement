<?php

namespace App\Entity;
 
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
 
#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
 
    #[ORM\Column]
    private ?float $prixTotal = null;
 
    #[ORM\Column(length: 50)]
    private ?string $nomUser = null;
 
    #[ORM\Column(length: 50)]
    private ?string $prenomUser = null;
 
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCommande = null;
 
    /**
     * @var Collection<int, DetailCommande>
     */
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: DetailCommande::class, cascade: ['persist', 'remove'])]
    private Collection $detailCommandes;
 
    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?User $user = null;
 
    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Livraison $livraison = null;
 
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $refCommande = null;
 
    public function __construct()
    {
        $this->detailCommandes = new ArrayCollection();
    }
 
    #[ORM\PrePersist]
    public function genereReference(): void
    {
        if ($this->refCommande === null) {
            $this->refCommande = sprintf('%06d', random_int(0, 999999));
        }
    }
 
    public function getId(): ?int
    {
        return $this->id;
    }
 
    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }
 
    public function setPrixTotal(float $prixTotal): static
    {
        $this->prixTotal = $prixTotal;
 
        return $this;
    }
 
    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }
 
    public function setNomUser(string $nomUser): static
    {
        $this->nomUser = $nomUser;
 
        return $this;
    }
 
    public function getPrenomUser(): ?string
    {
        return $this->prenomUser;
    }
 
    public function setPrenomUser(string $prenomUser): static
    {
        $this->prenomUser = $prenomUser;
 
        return $this;
    }
 
    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }
 
    public function setDateCommande(\DateTimeInterface $dateCommande): static
    {
        $this->dateCommande = $dateCommande;
 
        return $this;
    }
 
    /**
     * @return Collection<int, DetailCommande>
     */
    public function getDetailCommandes(): Collection
    {
        return $this->detailCommandes;
    }
 
    public function addDetailCommande(DetailCommande $detailCommande): static
    {
        foreach ($this->detailCommandes as $existingDetail) {
            if ($existingDetail->getProduit()->getId() === $detailCommande->getProduit()->getId()) {
                // Augmenter la quantité si le produit existe déjà
                $existingDetail->setQuantite($existingDetail->getQuantite() + $detailCommande->getQuantite());
                return $this;
            }
        }
 
        $this->detailCommandes->add($detailCommande);
        $detailCommande->setCommande($this);
 
        return $this;
    }
 
    public function removeDetailCommande(DetailCommande $detailCommande): static
    {
        if ($this->detailCommandes->removeElement($detailCommande)) {
            if ($detailCommande->getCommande() === $this) {
                $detailCommande->setCommande(null);
            }
        }
 
        return $this;
    }
 
    public function getUser(): ?User
    {
        return $this->user;
    }
 
    public function setUser(?User $user): static
    {
        $this->user = $user;
 
        return $this;
    }
 
    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }
 
    public function setLivraison(?Livraison $livraison): static
    {
        $this->livraison = $livraison;
 
        return $this;
    }
 
    public function getRefCommande(): ?string
    {
        return $this->refCommande;
    }
 
    public function setRefCommande(string $refCommande): static
    {
        $this->refCommande = $refCommande;
 
        return $this;
    }
}