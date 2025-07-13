<?php

namespace App\Request;

use App\Core\Request\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateLikeOnPostRequest implements RequestInterface
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $creatorId = null;

    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $postId = null;
}

