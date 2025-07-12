<?php

namespace App\Request;

use App\Core\Request\RequestInterface;
use App\Entity\UserEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

class CreateFanTokenRequest implements RequestInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    public ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    public ?string $symbol = null;

    #[Assert\NotNull]
    #[Assert\Type('float')]
    #[Assert\Range(min: 0.01, max: 1000000)]
    public ?float $price = null;

    #[Assert\NotNull]
    #[Assert\Type('float')]
    #[Assert\PositiveOrZero]
    #[Assert\LessThanOrEqual(1000000000)]
    public ?float $totalSupply = null;

    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $communityId = null;
}
