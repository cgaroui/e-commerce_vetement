<?php

namespace App\Entity;

use App\Repository\NewsletterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterRepository::class)]
class Newsletter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEnvoie = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    /**
     * @var Collection<int, NewsletterProspet>
     */
    #[ORM\OneToMany(targetEntity: NewsletterProspet::class, mappedBy: 'newsletter')]
    private Collection $newsletterProspets;

    public function __construct()
    {
        $this->newsletterProspets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->dateEnvoie;
    }

    public function setDateEnvoie(\DateTimeInterface $dateEnvoie): static
    {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

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
            $newsletterProspet->setNewsletter($this);
        }

        return $this;
    }

    public function removeNewsletterProspet(NewsletterProspet $newsletterProspet): static
    {
        if ($this->newsletterProspets->removeElement($newsletterProspet)) {
            // set the owning side to null (unless already changed)
            if ($newsletterProspet->getNewsletter() === $this) {
                $newsletterProspet->setNewsletter(null);
            }
        }

        return $this;
    }
}
