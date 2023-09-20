<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\Repository\HobbyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
                                'hobby' => 'test_hobby',
                            ],
                            ],
                        ])
                )
            ),
        ),
    ],
    formats: ['json' => ['application/json']],
    normalizationContext: ['groups' => ['hobby:read']],
    denormalizationContext: ['groups' => ['hobby:write']],
)]
#[ORM\Entity(repositoryClass: HobbyRepository::class)]
class Hobby
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'preference:read', 'hobby:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['hobby:write', 'hobby:read', 'user:read', 'preference:read'])]
    private ?string $hobby = null;

    #[ORM\ManyToMany(targetEntity: UserPreference::class, mappedBy: 'hobbies')]
    private Collection $userPreferences;

    public function __construct()
    {
        $this->userPreferences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHobby(): ?string
    {
        return $this->hobby;
    }

    public function setHobby(string $hobby): static
    {
        $this->hobby = $hobby;

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
            $userPreference->addHobby($this);
        }

        return $this;
    }

    public function removeUserPreference(UserPreference $userPreference): static
    {
        if ($this->userPreferences->removeElement($userPreference)) {
            $userPreference->removeHobby($this);
        }

        return $this;
    }
}
