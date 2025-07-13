<?php

namespace App\Entity;

use App\Core\Persistence\Entity\AbstractEntity;
use App\Core\Persistence\Entity\Trait\EntityTrait;
use App\Repository\CommunityPostReactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommunityPostReactionRepository::class)]
#[ORM\Table(name: "community_post_reactions", uniqueConstraints: [
    new ORM\UniqueConstraint(columns: ['creator_id', 'post_id'])
])]
class CommunityPostReactionEntity extends AbstractEntity
{
    use EntityTrait;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 10)]
    #[ORM\Column(length: 10, nullable: false)]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserEntity $creator = null;

    #[ORM\ManyToOne(targetEntity: CommunityPostEntity::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?CommunityPostEntity $post = null;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;
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

    public function getPost(): ?CommunityPostEntity
    {
        return $this->post;
    }

    public function setPost(?CommunityPostEntity $post): self
    {
        $this->post = $post;
        return $this;
    }
}
