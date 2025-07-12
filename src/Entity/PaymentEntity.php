<?php

namespace App\Entity;

use App\Core\Persistence\Entity\AbstractEntity;
use App\Core\Persistence\Entity\Trait\EntityTrait;
use App\Repository\CommunityEntityRepository;
use App\Repository\PaymentEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PaymentEntityRepository::class)]
#[ORM\Table(name: "payments")]
class PaymentEntity extends AbstractEntity
{
    use EntityTrait;

    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserEntity $user = null;

    #[ORM\Column(nullable: false)]
    private ?string $type = null;

    #[ORM\Column(nullable: false)]
    private ?float $price = null;
    #[ORM\Column(nullable: false)]
    private ?float $amount = null;
    #[ORM\Column(length: 50, nullable: false)]
    private ?string $currency = null;
    #[ORM\ManyToOne(targetEntity: FanTokenEntity::class)]
    private ?FanTokenEntity $relatedToken = null;

    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

    public function setUser(?UserEntity $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;
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

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;
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
}
