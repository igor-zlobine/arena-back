<?php

namespace App\Request;

use App\Core\Request\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUserFanTokenRequest implements RequestInterface
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $userId = null;

    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $tokenId = null;

    #[Assert\NotNull]
    #[Assert\Type('float')]
    #[Assert\PositiveOrZero]
    #[Assert\LessThanOrEqual(1000000000)]
    public ?float $amount = null;
}
