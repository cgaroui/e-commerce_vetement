<?php

namespace App\Entity;

use App\Repository\ProspetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProspetRepository::class)]
class Prospet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    /**
     * @var Collection<int, NewsletterProspet>
     */
    #[ORM\OneToMany(targetEntity: NewsletterProspet::class, mappedBy: 'prospet')]
    private Collection $newsletterProspets;

    public function __construct()
    {
        $this->newsletterProspets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * @return Collection<int, NewsletterProspet>
     */
    public function getNewsletterProspets(): Collection
    {
        return $this->newsletterProspets;
    }

    public function addNewsletterProspet(NewsletterProspet $newsletterProspet): static
    {
        if (!$this->newsletterProspets->contains($newsletterProspet)) {
            $this->newsletterProspets->add($newsletterProspet);
            $newsletterProspet->setProspet($this);
        }

        return $this;
    }

    public function removeNewsletterProspet(NewsletterProspet $newsletterProspet): static
    {
        if ($this->newsletterProspets->removeElement($newsletterProspet)) {
            // set the owning side to null (unless already changed)
            if ($newsletterProspet->getProspet() === $this) {
                $newsletterProspet->setProspet(null);
            }
        }

        return $this;
    }
}
