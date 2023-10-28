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
    private ?int $ChoosingUserId = null;

    #[ORM\Column]
    private ?int $RatedUserId = null;

    #[ORM\Column]
    private ?bool $Rate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChoosingUserId(): ?int
    {
        return $this->ChoosingUserId;
    }

    public function setChoosingUserId(int $ChoosingUserId): static
    {
        $this->ChoosingUserId = $ChoosingUserId;

        return $this;
    }

    public function getRatedUserId(): ?int
    {
        return $this->RatedUserId;
    }

    public function setRatedUserId(int $RatedUserId): static
    {
        $this->RatedUserId = $RatedUserId;

        return $this;
    }

    public function isRate(): ?bool
    {
        return $this->Rate;
    }

    public function setRate(bool $Rate): static
    {
        $this->Rate = $Rate;

        return $this;
    }
}
