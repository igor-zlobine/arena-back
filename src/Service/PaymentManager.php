<?php

namespace App\Service;

use App\Core\Exception\NotFoundException;
use App\Entity\CommunityEntity;
use App\Entity\FanTokenEntity;
use App\Entity\PaymentEntity;
use App\Entity\UserEntity;
use App\Repository\FanTokenEntityRepository;
use App\Repository\PaymentEntityRepository;
use App\Repository\UserEntityRepository;
use App\Request\CreateFanTokenRequest;
use App\Request\CreatePaymentRequest;
use App\Request\CreateUserRequest;
use App\Request\UpdateFanTokenRequest;
use App\Service\Security\UserPasswordManager;
use Doctrine\ORM\EntityManagerInterface;

class PaymentManager extends AbstractManager
{

    public function __construct(
        EntityManagerInterface $em
    )
    {
        parent::__construct($em);
    }

    public function createPayment(CreatePaymentRequest $request): PaymentEntity
    {
        $entity = new PaymentEntity()
            ->setType($request->type)
            ->setAmount($request->amount)
            ->setPrice($request->price)
            ->setCurrency($request->currency)
        ;

        $user = $this->getEntityById(UserEntity::class, $request->userId);
        $token = $this->getEntityById(FanTokenEntity::class, $request->tokenId);

        $entity
            ->setUser($user)
            ->setRelatedToken($token);


        return $this->getRepository()->save($entity);
    }

    /*** @return PaymentEntity[] */
    public function fetchPaymentsByUserId(string $userId): array
    {
        return $this->getRepository()->findBy(
            [
                'user' => $userId,
            ]
        );
    }

    public function getById(string $id): PaymentEntity
    {
        return $this->getEntityById(PaymentEntity::class, $id);
    }

    public function getRepository(): PaymentEntityRepository
    {
        return $this->getEntityRepository(PaymentEntity::class);
    }
}
