<?php

namespace App\Service;

use App\Core\Exception\NotFoundException;
use App\Entity\CommunityEntity;
use App\Entity\CommunityPostEntity;
use App\Entity\FanTokenEntity;
use App\Entity\PaymentEntity;
use App\Entity\UserEntity;
use App\Entity\UserFanTokenEntity;
use App\Repository\CommunityPostRepository;
use App\Repository\FanTokenEntityRepository;
use App\Repository\PaymentEntityRepository;
use App\Repository\UserEntityRepository;
use App\Repository\UserFanTokenEntityRepository;
use App\Request\CreateCommunityPostRequest;
use App\Request\CreateFanTokenRequest;
use App\Request\CreatePaymentRequest;
use App\Request\CreateUserFanTokenRequest;
use App\Request\CreateUserRequest;
use App\Request\UpdateCommunityPostRequest;
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

    public function updatePost(UpdateCommunityPostRequest $request): CommunityPostEntity
    {
        $entity = $this->getEntityById(CommunityPostEntity::class, $request->id);
        $entity->setContent($request->content);

        return $this->getRepository()->save($entity);
    }

    /*** @return CommunityPostEntity[] */
    public function fetchPostByCommunity(string $communityId): array
    {
        return $this->getRepository()->findBy(
            [
                'community' => $communityId,
            ]
        );
    }

    public function getById(string $id): CommunityPostEntity
    {
        return $this->getEntityById(CommunityPostEntity::class, $id);
    }

    public function getRepository(): CommunityPostRepository
    {
        return $this->getEntityRepository(CommunityPostEntity::class);
    }
}
