<?php

namespace App\Request;

use App\Core\Request\RequestInterface;
use App\Entity\UserEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateCommunityRequest implements RequestInterface
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    public ?string $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 1200)]
    public ?string $description = null;
}
