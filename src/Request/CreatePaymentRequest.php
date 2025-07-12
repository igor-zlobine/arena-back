<?php

namespace App\Request;

use App\Core\Request\RequestInterface;
use App\Entity\UserEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

class CreatePaymentRequest implements RequestInterface
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $userId = null;

    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $tokenId = null;

    #[Assert\NotNull]
    #[Assert\Type('float')]
    #[Assert\Range(min: 0.01, max: 1000000)]
    public ?float $price = null;

    #[Assert\NotNull]
    #[Assert\Type('float')]
    #[Assert\PositiveOrZero]
    #[Assert\LessThanOrEqual(1000000000)]
    public ?float $amount = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 20)]
    public ?string $type = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 20)]
    public ?string $currency = null;

}
