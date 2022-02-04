<?php

namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ClientConstraintValidator extends ConstraintValidator{

    public function validate($client, Constraint $constraint)
    {
        $firstName = $client->getFirstName();
        $lastName = $client->getLastName();

        if(!$constraint instanceof  ClientConstraint){
            throw new UnexpectedTypeException($constraint, ClientConstraint::class);
        }

        if ($firstName === null && $lastName === null){
            return;
        }

        $firstNameCount = strlen($firstName);
        $lastNameCount = strlen($lastName);

        $count = $firstNameCount + $lastNameCount;

        if($count < 10){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $count)
                ->atPath('firstName')
                ->addViolation();
        }
    }
}
