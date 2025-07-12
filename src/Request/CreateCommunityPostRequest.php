<?php

namespace App\Request;

use App\Core\Request\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCommunityPostRequest implements RequestInterface
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $creatorId = null;

    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $communityId = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    public ?string $type = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 500)]
    #[Assert\Url]
    public ?string $contentUrl = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 2000)]
    public ?string $content = null;

}

