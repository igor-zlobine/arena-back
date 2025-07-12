<?php

namespace App\Entity;

use App\Core\Persistence\Entity\AbstractEntity;
use App\Core\Persistence\Entity\Trait\EntityTrait;
use App\Core\Tools\EnumHelper;
use App\Model\Features\Security\Enum\AuthTokenTypeEnum;
use App\Model\Persistence\Repository\Security\AuthTokenEntityRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthTokenEntityRepository::class)]
#[ORM\Table(name: "auth_token")]
class AuthTokenEntity extends AbstractEntity
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private $id;

    #[ORM\Column]
    private ?string $hash = null;

    #[ORM\Column]
    private string $salt;

    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', unique: false, nullable: false)]
    private UserEntity $user;
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTime $expiresAt;
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTime $usedAt = null;
    #[ORM\Column(nullable: false, options: ['default' => true])]
    private bool $active = true;

    public function getType(): AuthTokenTypeEnum
    {
        return EnumHelper::enum(AuthTokenTypeEnum::class)::tryFromName($this->type);
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): self
    {
        $this->salt = $salt;
        return $this;
    }

    public function getUser(): UserEntity
    {
        return $this->user;
    }

    public function setUser(UserEntity $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getExpiresAt(): DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTime $expiresAt): self
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }

    public function getUsedAt(): ?DateTime
    {
        return $this->usedAt;
    }

    public function setUsedAt(?DateTime $usedAt): self
    {
        $this->usedAt = $usedAt;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function isUsed(): bool
    {
        return $this->usedAt instanceof \DateTime;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;
        return $this;
    }

}
