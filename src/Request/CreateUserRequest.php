<?php

namespace App\Request;

use App\Core\Request\RequestInterface;
use App\Entity\UserEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('email', entityClass: UserEntity::class)]
class CreateUserRequest implements RequestInterface
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public ?string $email = null;
//    public ?string $password = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    public ?string $firstName = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    public ?string $lastName = null;

    public ?string $title = null;

    public ?string $about = null;
}
