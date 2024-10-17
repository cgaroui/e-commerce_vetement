<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
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
    #[ORM\OneToMany(targetEntity: DetailCommande::class, mappedBy: 'commande')]
    private Collection $detailCommandes;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Livraison $livraison = null;

    #[ORM\Column(length: 255)]
    private ?string $refCommande = null;

    public function __construct()
    {
        $this->detailCommandes = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function genereReference(): void
    {
        if ($this->refCommande === null) {
            $this->refCommande = sprintf('%06d', random_int(0, 999999)); // Générer un code à 6 chiffres
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

 /**
     * Get the value of nomUser
     */ 
    public function getNomUser()
    {
        return $this->nomUser;
    }

    /**
     * Set the value of nomUser
     *
     * @return  self
     */ 
    public function setNomUser($nomUser)
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
        $this->prenomUser = $prenomUser();

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

    //dans cette fonction si le produit existe deja dans le panier alors on augmente la quantité au lieux de l'ajouter plusieurs fois  
    // public function addDetailCommande(DetailCommande $article): static
    // {
    //     if (!$this->detailCommandes->contains($article)) {
    //         $this->detailCommandes->add($article);
    //         $article->setCommande($this);
    //     }else
    //     {
    //         $this->article->getQuantite()+ $article->getQuantite();
    //         return $this;
    //     }

    //     return $this;
    // }

    public function removeDetailCommande(DetailCommande $detailCommande): static
    {
        if ($this->detailCommandes->removeElement($detailCommande)) {
            // set the owning side to null (unless already changed)
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
