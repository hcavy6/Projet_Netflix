<?php

namespace App\Entity;

use App\Repository\WatchlistRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WatchlistRepository::class)]
class Watchlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $addedAt = null;

    public function __construct()
    {
    $this->addedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
    return $this->id;
    }

    public function getUser(): ?User
    {
    return $this->user;
    }

    public function setUser(?User $user): self
    {
    $this->user = $user;
    return $this;
    }

    public function getAddedAt(): ?\DateTimeImmutable
    {
    return $this->addedAt;
    }
}
