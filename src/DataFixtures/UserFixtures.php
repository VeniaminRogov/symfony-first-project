<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture{

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('banned@email.ru');
        $user->setRoles(['ROLE_USER']);
        $password = $this->hasher->hashPassword($user, 'banned');
        $user->setPassword($password);
        $user->setIsVerified(true);
        $user->setIsBanned(true);

        $manager->persist($user);
        $manager->flush();
    }
}