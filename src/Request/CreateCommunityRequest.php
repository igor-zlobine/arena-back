<?php

namespace App\Request;

use App\Core\Request\RequestInterface;
use App\Entity\UserEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCommunityRequest implements RequestInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 1200)]
    public ?string $description = null;

    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $creatorId = null;

    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $tokenId = null;
}
