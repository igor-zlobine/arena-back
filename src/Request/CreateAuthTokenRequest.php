<?php

namespace App\Request;

use App\Core\Request\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateAuthTokenRequest implements RequestInterface
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $userId = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public ?string $secret = null;

}
