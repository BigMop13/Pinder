<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\UserDetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
    ],
    formats: ['json' => ['application/json']],
    normalizationContext: ['groups' => ['details:read']],
    denormalizationContext: ['groups' => ['details:write']],
)]
#[ORM\Entity(repositoryClass: UserDetailsRepository::class)]
class UserDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['user:read', 'details:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read', 'details:read'])]
    private ?string $education = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read', 'details:read'])]
    private ?string $work = null;

    #[ORM\OneToMany(mappedBy: 'userDetails', targetEntity: Image::class, cascade: ['persist'])]
    #[Groups(['user:read', 'details:read'])]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: Hobby::class, inversedBy: 'userDetails')]
    private Collection $hobbies;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->hobbies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(?string $education): static
    {
        $this->education = $education;

        return $this;
    }

    public function getWork(): ?string
    {
        return $this->work;
    }

    public function setWork(?string $work): static
    {
        $this->work = $work;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setUserDetails($this);
        }

        return $this;
    }

    /**
     * @return UserDetails
     */
    public function setImages(Collection $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function setHobbies(Collection $hobbies): static
    {
        $this->hobbies = $hobbies;

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getUserDetails() === $this) {
                $image->setUserDetails(null);
            }
        }

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
