<?php

namespace App\Service\Security;

use App\Core\Exception\AccessDeniedException;
use App\Entity\UserEntity;
use App\Service\AbstractManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPasswordManager extends AbstractManager
{
    public function __construct(
        EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
        parent::__construct($em);
    }

    public function updatePassword(UserEntity $user, string $password): UserEntity
    {
        $password = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($password);
        return $user;
    }

    public function checkPassword(UserEntity $user, string $password): bool
    {
        return $this->passwordHasher->isPasswordValid($user,$password);
    }

}
