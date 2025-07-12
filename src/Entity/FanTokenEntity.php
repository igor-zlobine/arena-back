<?php

namespace App\Entity;

use App\Core\Persistence\Entity\AbstractEntity;
use App\Core\Persistence\Entity\Trait\EntityTrait;
use App\Repository\CommunityEntityRepository;
use App\Repository\FanTokenEntityRepository;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FanTokenEntityRepository::class)]
#[ORM\Table(name: "fan_tokens")]
class FanTokenEntity extends AbstractEntity
{
    use EntityTrait;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    #[ORM\Column(length: 50, nullable: false)]
    private ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    #[ORM\Column(length: 50, nullable: false)]
    private ?string $symbol = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    #[ORM\Column(nullable: false)]
    private ?float $price = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    #[ORM\Column(nullable: false)]
    private ?float $totalSupply = null;

    #[Assert\NotNull]
    #[ORM\OneToOne(targetEntity: CommunityEntity::class, inversedBy: 'fanToken')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CommunityEntity $community = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(?string $symbol): self
    {
        $this->symbol = $symbol;
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

    public function getTotalSupply(): ?float
    {
        return $this->totalSupply;
    }

    public function setTotalSupply(?float $totalSupply): self
    {
        $this->totalSupply = $totalSupply;
        return $this;
    }

    public function getCommunity(): ?CommunityEntity
    {
        return $this->community;
    }

    public function setCommunity(?CommunityEntity $community): self
    {
        $this->community = $community;
        return $this;
    }

}
