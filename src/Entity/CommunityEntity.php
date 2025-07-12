<?php

namespace App\Entity;

use App\Core\Persistence\Entity\AbstractEntity;
use App\Core\Persistence\Entity\Trait\EntityTrait;
use App\Repository\CommunityEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommunityEntityRepository::class)]
#[ORM\Table(name: "communities")]
class CommunityEntity extends AbstractEntity
{
    use EntityTrait;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    #[ORM\Column(length: 255, nullable: false)]
    private ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 1200)]
    #[ORM\Column(type: 'text', nullable: false)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserEntity $creator = null;

    #[ORM\OneToOne(targetEntity: FanTokenEntity::class, mappedBy: 'community', cascade: ['persist', 'remove'])]
    private ?FanTokenEntity $fanToken = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCreator(): ?UserEntity
    {
        return $this->creator;
    }

    public function setCreator(?UserEntity $creator): self
    {
        $this->creator = $creator;
        return $this;
    }

    public function getFanToken(): ?FanTokenEntity
    {
        return $this->fanToken;
    }

    public function setFanToken(?FanTokenEntity $fanToken): self
    {
        $this->fanToken = $fanToken;
        return $this;
    }
}
