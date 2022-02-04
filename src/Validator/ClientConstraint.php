<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class ClientConstraint extends Constraint{
    public $message = 'Your first name and last name must be greater than 10, you have - {{ string }}';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}