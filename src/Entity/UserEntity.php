<?php

namespace App\Entity;

use App\Core\Persistence\Entity\AbstractEntity;
use App\Core\Persistence\Entity\Trait\EntityTrait;
use App\Repository\UserEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation AS JMS;

#[ORM\Entity(repositoryClass: UserEntityRepository::class)]
#[ORM\Table(name: "users")]
#[JMS\ExclusionPolicy(policy: 'NONE')]
class UserEntity extends AbstractEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    use EntityTrait;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    #[ORM\Column(length: 50)]
    private ?string $firstName = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    #[ORM\Column(length: 50)]
    private ?string $lastName = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 255)]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $about;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $email = null;

    #[JMS\Exclude]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $password = null;

    public function __construct()
    {

    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        $this->password = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
