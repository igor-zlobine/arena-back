<?php

namespace App\Service;

use App\Core\Exception\NotFoundException;
use App\Entity\CommunityEntity;
use App\Entity\FanTokenEntity;
use App\Entity\PaymentEntity;
use App\Entity\UserEntity;
use App\Entity\UserFanTokenEntity;
use App\Repository\FanTokenEntityRepository;
use App\Repository\PaymentEntityRepository;
use App\Repository\UserEntityRepository;
use App\Repository\UserFanTokenEntityRepository;
use App\Request\CreateFanTokenRequest;
use App\Request\CreatePaymentRequest;
use App\Request\CreateUserFanTokenRequest;
use App\Request\CreateUserRequest;
use App\Request\UpdateFanTokenRequest;
use App\Service\Security\UserPasswordManager;
use Doctrine\ORM\EntityManagerInterface;

class UserFanTokenManager extends AbstractManager
{

    public function __construct(
        EntityManagerInterface $em
    )
    {
        parent::__construct($em);
    }

    public function createUserFanToken(CreateUserFanTokenRequest $request): UserFanTokenEntity
    {
        $entity = new UserFanTokenEntity()
            ->setAmount($request->amount)
        ;

        $user = $this->getEntityById(UserEntity::class, $request->userId);
        $token = $this->getEntityById(FanTokenEntity::class, $request->tokenId);

        $entity
            ->setUser($user)
            ->setRelatedToken($token);


        return $this->getRepository()->save($entity);
    }

    /*** @return PaymentEntity[] */
    public function fetchUserFanTokens(string $userId): array
    {
        return $this->getRepository()->findBy(
            [
                'user' => $userId,
            ]
        );
    }

    public function getById(string $id): UserFanTokenEntity
    {
        return $this->getEntityById(UserFanTokenEntity::class, $id);
    }

    public function getRepository(): UserFanTokenEntityRepository
    {
        return $this->getEntityRepository(UserFanTokenEntity::class);
    }
}
