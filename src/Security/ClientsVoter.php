<?php

namespace App\Security;

use App\Entity\Client;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ClientsVoter extends Voter {
    const EDIT = 'edit';
    const DELETE = 'delete';

    private $security;

    public function __construct(Security $security){
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        if(!in_array($attribute, [self::DELETE, self::EDIT])){
            return false;
        }

        if(!$subject instanceof Client){
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {   $user = $token->getUser();

        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }

        if(!$user instanceof User){
            return false;
        }

        $client = $subject;

        switch ($attribute){
            case self::EDIT:
                return $this->canEdit($client, $user);
            case self::DELETE:
                return $this->canDelete();
        }
    }

    public function canDelete(): bool {
        if(!$this->security->isGranted("ROLE_ADMIN")){
            return false;
        }
        return true;
    }

    public function canEdit(Client $client, User $user): bool{
        if($this->security->isGranted("ROLE_ADMIN")){
            return true;
        }
        return $user === $client->getUser();
    }
}