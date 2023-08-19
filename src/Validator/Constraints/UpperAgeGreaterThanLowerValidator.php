<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Dto\Registration\UserPreferenceInput;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class UpperAgeGreaterThanLowerValidator extends ConstraintValidator
{
    /**
     * @param UserPreferenceInput      $value
     * @param UpperAgeGreaterThanLower $constraint
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$value) {
            return;
        }

        $lowerAge = $value->lowerAgeRange;
        $upperAge = $value->upperAgeRange;

        if ($upperAge <= $lowerAge) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
