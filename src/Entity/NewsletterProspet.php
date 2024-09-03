<?php

namespace App\Entity;

use App\Repository\NewsletterProspetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterProspetRepository::class)]
class NewsletterProspet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'newsletterProspets')]
    private ?Prospet $prospet = null;

    #[ORM\ManyToOne(inversedBy: 'newsletterProspets')]
    private ?Newsletter $newsletter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProspet(): ?Prospet
    {
        return $this->prospet;
    }

    public function setProspet(?Prospet $prospet): static
    {
        $this->prospet = $prospet;

        return $this;
    }

    public function getNewsletter(): ?Newsletter
    {
        return $this->newsletter;
    }

    public function setNewsletter(?Newsletter $newsletter): static
    {
        $this->newsletter = $newsletter;

        return $this;
    }
}
