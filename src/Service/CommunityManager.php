<?php

namespace App\Service;

use App\Core\Exception\NotFoundException;
use App\Entity\CommunityEntity;
use App\Entity\UserEntity;
use App\Repository\CommunityEntityRepository;
use App\Repository\UserEntityRepository;
use App\Request\CreateCommunityRequest;
use App\Request\CreateUserRequest;
use App\Request\UpdateCommunityRequest;
use App\Service\Security\UserPasswordManager;
use Doctrine\ORM\EntityManagerInterface;

class CommunityManager extends AbstractManager
{

    public function __construct(
        private UserManager $userManager,
        EntityManagerInterface $em,
    )
    {
        parent::__construct($em);
    }

    public function createCommunity(CreateCommunityRequest $request): CommunityEntity
    {
        $entity = new CommunityEntity()
            ->setName($request->name)
            ->setDescription($request->description)
            ->setCreator($this->userManager->getUserById($request->creatorId))
//            ->setTokenId($request->tokenId);
        ;


        $this->getCommunityEntityRepository()->save($entity);
        return $entity;
    }

    public function updateCommunity(UpdateCommunityRequest $request): CommunityEntity
    {

        $entity = $this->getById($request->id);

        $entity = $entity
            ->setDescription($request->description)
        ;
        
        return $this->getCommunityEntityRepository()->save($entity);
    }


    public function fetchAll(): array
    {
        $communities = $this->getCommunityEntityRepository()->findAll();
        if (empty($communities)) {
            throw new NotFoundException('No communities found');
        }
        return $communities;
    }


    /**
     * @throws NotFoundException
     */
    public function getById(string $id): CommunityEntity
    {
        return $this->getEntityById(CommunityEntity::class, $id);
    }

    public function getCommunityEntityRepository(): CommunityEntityRepository
    {
        return $this->getEntityRepository(CommunityEntity::class);
    }
}
