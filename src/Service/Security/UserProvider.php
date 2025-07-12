<?php

namespace App\Service\Security;

use App\Core\Exception\AccessDeniedException;
use App\Entity\UserEntity;
use App\Service\UserManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

readonly class UserProvider implements UserProviderInterface
{
    public function __construct(
        private UserManager $userManager
    ) {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->getUser($user);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->getUserByUserId($identifier);
    }

    public function supportsClass(string $class): bool
    {
        return UserEntity::class === $class || is_subclass_of($class, UserEntity::class);
    }

    private function getUser(UserEntity $user): UserInterface
    {
        return $this->getUserByUserId($user->getId());
    }

    private function getUserByUserId(string $userId): UserInterface
    {
        $user = $this->userManager->getUserById($userId);

        if (!$user)
        {
            throw new AccessDeniedException();
        }

        return $user;
    }

}
