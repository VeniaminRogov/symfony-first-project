<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface{

    public function checkPreAuth(UserInterface $user)
    {
        if(!$user instanceof User){
            return;
        }

        if(!$user->getIsVerified()){
            throw new CustomUserMessageAuthenticationException('Verify your email');
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if(!$user instanceof User){
            return;
        }

        if($user->getIsBanned()){
            throw new CustomUserMessageAccountStatusException('You are banned!');
        }
    }
}