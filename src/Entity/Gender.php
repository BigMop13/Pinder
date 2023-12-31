<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\Repository\GenderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            openapi: new Model\Operation(
                summary: 'Create user',
                requestBody: new Model\RequestBody(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'name' => ['type' => 'string'],
                                    'description' => ['type' => 'string'],
                                ],
                            ],
                            'example' => [
                                'sex' => 'gender_example',
                            ],
                        ],
                    ])
                )
            ),
        ),
    ],
    formats: ['json' => ['application/json']],
    normalizationContext: ['groups' => ['gender:read']],
    denormalizationContext: ['groups' => ['gender:write']],
)]
#[ORM\Entity(repositoryClass: GenderRepository::class)]
class Gender
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['gender:read', 'user:read', 'preference:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['gender:read', 'gender:write', 'user:read', 'preference:read'])]
    #[SerializedName('gender')]
    private ?string $sex = null;

    #[ORM\OneToMany(mappedBy: 'sex', targetEntity: User::class)]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: UserPreference::class, mappedBy: 'genders')]
    private Collection $userPreferences;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->userPreferences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setSex($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getSex() === $this) {
                $user->setSex(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserPreference>
     */
    public function getUserPreferences(): Collection
    {
        return $this->userPreferences;
    }

    public function addUserPreference(UserPreference $userPreference): static
    {
        if (!$this->userPreferences->contains($userPreference)) {
            $this->userPreferences->add($userPreference);
            $userPreference->addGender($this);
        }

        return $this;
    }

    public function removeUserPreference(UserPreference $userPreference): static
    {
        if ($this->userPreferences->removeElement($userPreference)) {
            $userPreference->removeGender($this);
        }

        return $this;
    }
}
