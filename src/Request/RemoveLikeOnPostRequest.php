<?php

namespace App\Request;

use App\Core\Request\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RemoveLikeOnPostRequest implements RequestInterface
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $likeId = null;
}

