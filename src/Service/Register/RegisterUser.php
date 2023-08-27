<?php

declare(strict_types=1);

namespace App\Service\Register;

use App\Dto\Registration\RegistrationInput;
use App\Exception\NoGenderFoundException;
use App\Factory\ImageFactory;
use App\Factory\Register\BaseUserFactory;
use App\Factory\Register\UserDetailsFactory;
use App\Factory\Register\UserPreferencesFactory;
use App\Repository\GenderRepository;
use App\Repository\HobbyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

readonly class RegisterUser
{
    public function __construct(
        private GenderRepository $genderRepository,
        private EntityManagerInterface $entityManager,
        private HobbyRepository $hobbyRepository
    ) {
    }

    /**
     * @throws NoGenderFoundException
     */
    public function registerUser(RegistrationInput $registerData): void
    {
        $userDetails = $registerData->userDetails;
        $userPreferences = $registerData->userPreference;
        $userGender = $this->genderRepository->find($registerData->genderId);
        $userPreferenceGender = $this->genderRepository->find($userPreferences->genderId);
        $userPreferenceHobbies = $this->searchForHobbies($userPreferences->hobbyIds);
        $images = $this->createImages($userDetails->imageUrls);

        if (!$userGender || !$userPreferenceGender) {
            throw new NoGenderFoundException('No gender found');
        }

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
            $userPreferenceGender,
            $userPreferences->lowerAgeRange,
            $userPreferences->upperAgeRange,
            $userPreferences->radiusDistance,
            $userPreferenceHobbies
        ));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param int[] $hobbyIds
     */
    private function searchForHobbies(array $hobbyIds): Collection
    {
        $hobbies = $this->hobbyRepository->getHobbiesFromArrayOfIds($hobbyIds);

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
