<?php

namespace App\Entity;

use App\Repository\UserSelectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSelectionRepository::class)]
class UserSelection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $choosingUserId = null;

    #[ORM\Column]
    private ?int $ratedUserId = null;

    #[ORM\Column]
    private ?bool $rate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChoosingUserId(): ?int
    {
        return $this->choosingUserId;
    }

    public function setChoosingUserId(int $choosingUserId): static
    {
        $this->choosingUserId = $choosingUserId;

        return $this;
    }

    public function getRatedUserId(): ?int
    {
        return $this->ratedUserId;
    }

    public function setRatedUserId(int $ratedUserId): static
    {
        $this->ratedUserId = $ratedUserId;

        return $this;
    }

    public function isRate(): ?bool
    {
        return $this->rate;
    }

    public function setRate(bool $rate): static
    {
        $this->rate = $rate;

        return $this;
    }
}
