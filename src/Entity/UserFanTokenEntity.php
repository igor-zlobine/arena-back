<?php

namespace App\Entity;

use App\Core\Persistence\Entity\AbstractEntity;
use App\Core\Persistence\Entity\Trait\EntityTrait;
use App\Repository\CommunityEntityRepository;
use App\Repository\PaymentEntityRepository;
use App\Repository\UserFanTokenEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserFanTokenEntityRepository::class)]
#[ORM\Table(name: "user_fan_tokens")]
class UserFanTokenEntity extends AbstractEntity
{
    use EntityTrait;

    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserEntity $user = null;

    #[ORM\ManyToOne(targetEntity: FanTokenEntity::class)]
    private ?FanTokenEntity $relatedToken = null;
    #[ORM\Column(nullable: false)]
    private ?float $amount = null;

    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

    public function setUser(?UserEntity $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getRelatedToken(): ?FanTokenEntity
    {
        return $this->relatedToken;
    }

    public function setRelatedToken(?FanTokenEntity $relatedToken): self
    {
        $this->relatedToken = $relatedToken;
        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }
}
