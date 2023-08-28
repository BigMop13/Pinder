<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\UserPreferenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
    ],
    formats: ['json' => ['application/json']],
    normalizationContext: ['groups' => ['preference:read']],
    denormalizationContext: ['groups' => ['preference:write']],
)]
#[ORM\Entity(repositoryClass: UserPreferenceRepository::class)]
class UserPreference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read', 'preference:read'])]
    private ?int $lowerAgeRange = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read', 'preference:read'])]
    private ?int $upperAgeRange = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read', 'preference:read'])]
    private ?int $radiusDistance = null;

    #[ORM\ManyToMany(targetEntity: Hobby::class, inversedBy: 'userPreferences', cascade: ['persist'])]
    #[Groups(['user:read', 'preference:read'])]
    private Collection $hobbies;

    #[ORM\ManyToMany(targetEntity: Gender::class, inversedBy: 'userPreferences', cascade: ['persist'])]
    #[Groups(['user:read', 'preference:read'])]
    private Collection $genders;

    public function __construct()
    {
        $this->hobbies = new ArrayCollection();
        $this->genders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return UserPreference
     */
    public function setHobbies(Collection $hobbies): static
    {
        $this->hobbies = $hobbies;

        return $this;
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

    /**
     * @return Collection<int, Gender>
     */
    public function getGenders(): Collection
    {
        return $this->genders;
    }

    public function addGender(Gender $gender): static
    {
        if (!$this->genders->contains($gender)) {
            $this->genders->add($gender);
        }

        return $this;
    }

    public function removeGender(Gender $gender): static
    {
        $this->genders->removeElement($gender);

        return $this;
    }

    public function setGenders(Collection $genders): static
    {
        $this->genders = $genders;

        return $this;
    }
}
