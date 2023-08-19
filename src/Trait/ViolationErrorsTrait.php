<?php

namespace App\Trait;

use Symfony\Component\Validator\ConstraintViolationListInterface;

trait ViolationErrorsTrait
{
    /**
     * @return array<string, array<string>>
     */
    public function extractErrorsFromViolations(ConstraintViolationListInterface $violations): array
    {
        $errors = [];
        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $errors;
    }
}
