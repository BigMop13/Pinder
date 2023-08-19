<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UpperAgeGreaterThanLower extends Constraint
{
    public string $message = 'Upper age property should be greater than lower age property".';

    public function getTargets(): array
    {
        return [parent::CLASS_CONSTRAINT, parent::PROPERTY_CONSTRAINT];
    }
}
