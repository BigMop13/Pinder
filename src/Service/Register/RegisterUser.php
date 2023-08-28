<?php

declare(strict_types=1);

namespace App\Service\Register;

use App\Dto\Registration\RegistrationInput;
use App\Entity\User;
use App\Factory\ImageFactory;
use App\Factory\Register\BaseUserFactory;
use App\Factory\Register\UserDetailsFactory;
use App\Factory\Register\UserPreferencesFactory;
use App\Repository\Interface\GenderRepositoryInterface;
use App\Repository\Interface\HobbyRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

readonly class RegisterUser
{
    public function __construct(
        private GenderRepositoryInterface $genderRepository,
        private EntityManagerInterface $entityManager,
        private HobbyRepositoryInterface $hobbyRepository
    ) {
    }

    public function createUser(RegistrationInput $registerData): void
    {
        $user = $this->registerUser($registerData);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    private function registerUser(RegistrationInput $registerData): User
    {
        $userDetails = $registerData->userDetails;
        $userPreferences = $registerData->userPreference;
        $userGender = $this->genderRepository->find($registerData->genderId);
        $userPreferenceGenders = $this->searchForGenders($userPreferences->genderIds);
        $userPreferenceHobbies = $this->searchForHobbies($userPreferences->hobbyIds);
        $images = $this->createImages($userDetails->imageUrls);

        $user = BaseUserFactory::create(
            $registerData->uid,
            $registerData->username,
            $userGender,
            $registerData->age,
            $registerData->address
        );

        $user->setUserDetails(UserDetailsFactory::create(
            $userDetails->description,
            $userDetails->education,
            $userDetails->work,
            $images
        ));

        $user->setUserPreferences(UserPreferencesFactory::create(
            $userPreferences->lowerAgeRange,
            $userPreferences->upperAgeRange,
            $userPreferences->radiusDistance,
            $userPreferenceHobbies,
            $userPreferenceGenders
        ));

        return $user;
    }

    /**
     * @param int[] $hobbyIds
     */
    private function searchForHobbies(array $hobbyIds): Collection
    {
        $hobbies = $this->hobbyRepository->getHobbiesFromArrayOfIds($hobbyIds);

        return new ArrayCollection($hobbies);
    }

    private function searchForGenders(array $genderIds): Collection
    {
        $hobbies = $this->genderRepository->getHobbiesFromArrayOfIds($genderIds);

        return new ArrayCollection($hobbies);
    }

    /**
     * @param string[] $imageUrls
     */
    private function createImages(array $imageUrls): Collection
    {
        $images = new ArrayCollection();
        foreach ($imageUrls as $imageUrl) {
            $images->add(ImageFactory::create($imageUrl));
        }

        return $images;
    }
}
