<?php

namespace App\Service;

use App\Core\Exception\NotFoundException;
use App\Entity\CommunityEntity;
use App\Entity\FanTokenEntity;
use App\Entity\UserEntity;
use App\Repository\FanTokenEntityRepository;
use App\Repository\UserEntityRepository;
use App\Request\CreateFanTokenRequest;
use App\Request\CreateUserRequest;
use App\Service\Security\UserPasswordManager;
use Doctrine\ORM\EntityManagerInterface;

class FanTokenManager extends AbstractManager
{

    public function __construct(
        private CommunityManager $communityManager,
        EntityManagerInterface $em
    )
    {
        parent::__construct($em);
    }

    public function createFanToken(CreateFanTokenRequest $request): FanTokenEntity
    {
        $entity = new FanTokenEntity()
            ->setName($request->name)
            ->setSymbol($request->symbol)
            ->setPrice($request->price)
            ->setTotalSupply($request->totalSupply)
        ;

        $community = $this->getEntityById(CommunityEntity::class, $request->communityId);

        $entity->setCommunity($community);

        return $this->getRepository()->save($entity);
    }

    /*** @return FanTokenEntity[] */
    public function fetchTokens(): array
    {
        return $this->getRepository()->findAll();
    }

    public function getById(string $id): FanTokenEntity
    {
        return $this->getEntityById(FanTokenEntity::class, $id);
    }

    public function getRepository(): FanTokenEntityRepository
    {
        return $this->getEntityRepository(FanTokenEntity::class);
    }
}
