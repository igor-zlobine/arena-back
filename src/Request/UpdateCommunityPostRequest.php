<?php

namespace App\Request;

use App\Core\Request\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateCommunityPostRequest implements RequestInterface
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 2000)]
    public ?string $content = null;

}
