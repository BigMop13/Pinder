<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\Controller\User\LoginUser;
use App\Controller\User\UserRegistration;
use App\Repository\UserRepository;
use ArrayObject;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    formats: ['json' => ['application/json']],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']]
)]
#[Get]
#[GetCollection]
#[Post(
    uriTemplate: '/user/register',
    controller: UserRegistration::class,
    openapi: new Model\Operation(
        summary: 'Create user',
        requestBody: new Model\RequestBody(
            content: new ArrayObject([
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'name' => ['type' => 'string'],
                            'description' => ['type' => 'string'],
                        ],
                    ],
                    'example' => [
                        'uid' => 'testUser',
                        'username' => 'string',
                        'genderId' => 1,
                        'age' => 0,
                        'address' => 'string',
                        'userPreference' => [
                            'genderId' => 1,
                            'lowerAgeRange' => 0,
                            'upperAgeRange' => 0,
                            'radiusDistance' => 0,
                            'hobbyIds' => [2, 4, 6],
                        ],
                        'userDetails' => [
                            'description' => 'string',
                            'education' => 'string',
                            'work' => 'string',
                            'imageUrls' => ['b', 'a', 'a', 'a'],
                        ],
                    ],
                ],
            ])
        )
    ),
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $uid = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $roles = ['ROLE_USER'];

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read'])]
    private ?string $username = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read'])]
    private ?Gender $sex = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $age = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read'])]
    private ?string $address = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read'])]
    private ?UserPreference $userPreferences = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read'])]
    private ?UserDetails $userDetails = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->uid;
    }

    public function setUid(?string $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function setSex(?Gender $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

//    public function setRoles(array $roles): static
//    {
//        $this->roles = $roles;
//
//        return $this;
//    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getSex(): ?Gender
    {
        return $this->sex;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getUserDetails(): ?UserDetails
    {
        return $this->userDetails;
    }

    public function setUserDetails(UserDetails $userDetails): static
    {
        $this->userDetails = $userDetails;

        return $this;
    }

    public function getUserPreferences(): ?UserPreference
    {
        return $this->userPreferences;
    }

    public function setUserPreferences(?UserPreference $userPreferences): static
    {
        $this->userPreferences = $userPreferences;

        return $this;
    }
}
