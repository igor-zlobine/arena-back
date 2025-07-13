<?php

namespace App\Service;

use App\Core\Exception\NotFoundException;
use App\Entity\CommunityEntity;
use App\Entity\CommunityPostEntity;
use App\Entity\CommunityPostReactionEntity;
use App\Entity\FanTokenEntity;
use App\Entity\PaymentEntity;
use App\Entity\UserEntity;
use App\Entity\UserFanTokenEntity;
use App\Repository\CommunityPostReactionRepository;
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
use App\Request\CreateLikeOnPostRequest;
use App\Request\RemoveLikeOnPostRequest;
use App\Request\UpdateCommunityPostRequest;
use App\Request\UpdateFanTokenRequest;
use App\Service\Security\UserPasswordManager;
use Doctrine\ORM\EntityManagerInterface;

class CommunityPostReactionsManager extends AbstractManager
{

    public function __construct(
        EntityManagerInterface $em
    )
    {
        parent::__construct($em);
    }

    public function createLike(CreateLikeOnPostRequest $request): CommunityPostReactionEntity
    {
        $entity = new CommunityPostReactionEntity()
            ->setType('like')
        ;

        $user = $this->getEntityById(UserEntity::class, $request->creatorId);
        $post = $this->getEntityById(CommunityPostEntity::class, $request->postId);

        $entity
            ->setCreator($user)
            ->setPost($post);

        $reaction = $this->getRepository()->findOneBy(
            [
                'creator' => $user,
                'post' => $post,
            ]
        );

        if ($reaction) {
            // If the reaction already exists, we can just return it
            return $reaction;
        }

        return $this->getRepository()->save($entity);
    }

    public function removeLike(RemoveLikeOnPostRequest $request): void
    {
        $entity = $this->getRepository()->findOneBy(
            [
                'id' => $request->likeId,
                'type' => 'like',
            ]
        );

        if (!$entity) {
            throw new NotFoundException('Like not found');
        }

        $this->getRepository()->remove($entity);
    }

    /*** @return CommunityPostReactionEntity[] */
    public function fetchReactionsByPost(string $postId): array
    {
        return $this->getRepository()->findBy(
            [
                'post' => $postId,
            ]
        );
    }

    public function getById(string $id): CommunityPostReactionEntity
    {
        return $this->getEntityById(CommunityPostReactionEntity::class, $id);
    }

    public function getRepository(): CommunityPostReactionRepository
    {
        return $this->getEntityRepository(CommunityPostReactionEntity::class);
    }
}
