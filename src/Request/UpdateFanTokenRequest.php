<?php

namespace App\Request;

use App\Core\Request\RequestInterface;
use App\Entity\UserEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateFanTokenRequest implements RequestInterface
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $id = null;

    #[Assert\NotNull]
    #[Assert\Type('float')]
    #[Assert\Range(min: 0.01, max: 1000000)]
    public ?float $price = null;
}
