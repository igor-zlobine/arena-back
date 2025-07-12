<?php

namespace App\Service;

use App\Core\Exception\NotFoundException;
use App\Entity\UserEntity;
use App\Repository\UserEntityRepository;
use App\Request\CreateUserRequest;
use App\Service\Security\UserPasswordManager;
use Doctrine\ORM\EntityManagerInterface;

class UserManager extends AbstractManager
{

    public function __construct(
        private UserPasswordManager $passwordManager,
        EntityManagerInterface $em
    )
    {
        parent::__construct($em);
    }

    public function createUser(CreateUserRequest $request): UserEntity
    {
        $userEntity = new UserEntity();
        $userEntity
            ->setEmail($request->email)
//            ->setPassword($request->password)
            ->setFirstName($request->firstName)
            ->setLastName($request->lastName)
            ->setTitle($request->title)
            ->setAbout($request->about);

//        $userEntity = $this->passwordManager->updatePassword($userEntity, $request->password);

        $this->getUserEntityRepository()->save($userEntity);
        return $userEntity;
    }

    /**
     * @throws NotFoundException
     */
    public function getUserById(string $id): UserEntity
    {
        return $this->getEntityById(UserEntity::class, $id);
    }

    public function getUserEntityRepository(): UserEntityRepository
    {
        return $this->getEntityRepository(UserEntity::class);
    }
}
