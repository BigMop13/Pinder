<?php

namespace App\Entity;

use App\Repository\UserPreferenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPreferenceRepository::class)]
class UserPreference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne]
    private ?Gender $sex = null;

    #[ORM\Column(nullable: true)]
    private ?int $lowerAgeRange = null;

    #[ORM\Column(nullable: true)]
    private ?int $upperAgeRange = null;

    #[ORM\Column(nullable: true)]
    private ?int $radiusDistance = null;

    #[ORM\ManyToMany(targetEntity: Hobby::class, inversedBy: 'userPreferences')]
    private Collection $hobbies;

    public function __construct()
    {
        $this->hobbies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getSex(): ?Gender
    {
        return $this->sex;
    }

    public function setSex(?Gender $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function getLowerAgeRange(): ?int
    {
        return $this->lowerAgeRange;
    }

    public function setLowerAgeRange(?int $lowerAgeRange): static
    {
        $this->lowerAgeRange = $lowerAgeRange;

        return $this;
    }

    public function getUpperAgeRange(): ?int
    {
        return $this->upperAgeRange;
    }

    public function setUpperAgeRange(?int $upperAgeRange): static
    {
        $this->upperAgeRange = $upperAgeRange;

        return $this;
    }

    public function getRadiusDistance(): ?int
    {
        return $this->radiusDistance;
    }

    public function setRadiusDistance(?int $radiusDistance): static
    {
        $this->radiusDistance = $radiusDistance;

        return $this;
    }

    /**
     * @return Collection<int, Hobby>
     */
    public function getHobbies(): Collection
    {
        return $this->hobbies;
    }

    public function addHobby(Hobby $hobby): static
    {
        if (!$this->hobbies->contains($hobby)) {
            $this->hobbies->add($hobby);
        }

        return $this;
    }

    public function removeHobby(Hobby $hobby): static
    {
        $this->hobbies->removeElement($hobby);

        return $this;
    }
}
