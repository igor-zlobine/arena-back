<?php

namespace App\Service;

use App\Core\Exception\NotFoundException;
use App\Entity\CommunityEntity;
use App\Entity\CommunityPostEntity;
use App\Entity\FanTokenEntity;
use App\Entity\PaymentEntity;
use App\Entity\UserEntity;
use App\Entity\UserFanTokenEntity;
use App\Repository\FanTokenEntityRepository;
use App\Repository\PaymentEntityRepository;
use App\Repository\UserEntityRepository;
use App\Repository\UserFanTokenEntityRepository;
use App\Request\CreateCommunityPostRequest;
use App\Request\CreateFanTokenRequest;
use App\Request\CreatePaymentRequest;
use App\Request\CreateUserFanTokenRequest;
use App\Request\CreateUserRequest;
use App\Request\UpdateFanTokenRequest;
use App\Service\Security\UserPasswordManager;
use Doctrine\ORM\EntityManagerInterface;

class UserCommunityPostManager extends AbstractManager
{

    public function __construct(
        EntityManagerInterface $em
    )
    {
        parent::__construct($em);
    }

    public function createPost(CreateCommunityPostRequest $request): CommunityPostEntity
    {
        $entity = new CommunityPostEntity()
            ->setType($request->type)
            ->setContentUrl($request->contentUrl)
            ->setContent($request->content)

        ;

        $user = $this->getEntityById(UserEntity::class, $request->creatorId);
        $community = $this->getEntityById(CommunityEntity::class, $request->communityId);

        $entity
            ->setCreator($user)
            ->setCommunity($community);


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
