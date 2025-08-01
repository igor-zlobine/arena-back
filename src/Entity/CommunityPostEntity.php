<?php

namespace App\Entity;

use App\Core\Persistence\Entity\AbstractEntity;
use App\Core\Persistence\Entity\Trait\EntityTrait;
use App\Repository\CommunityPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation AS JMS;

#[ORM\Entity(repositoryClass: CommunityPostRepository::class)]
#[ORM\Table(name: "community_posts")]
#[JMS\ExclusionPolicy('NONE')]
class CommunityPostEntity extends AbstractEntity
{
    use EntityTrait;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 10)]
    #[ORM\Column(length: 10, nullable: false)]
    private ?string $type = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 1000)]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $contentUrl = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 2000)]
    #[ORM\Column(type: 'text', nullable: false)]
    private ?string $content = null;

    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserEntity $creator = null;

    #[ORM\ManyToOne(targetEntity: CommunityEntity::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?CommunityEntity $community = null;

    #[JMS\Exclude]
    #[ORM\OneToMany(targetEntity: CommunityPostReactionEntity::class, mappedBy: 'post', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $reactions;


    public function __construct()
    {
        $this->generateId();
        $this->reactions = new ArrayCollection();
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

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(?string $contentUrl): self
    {
        $this->contentUrl = $contentUrl;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;
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

    public function getCommunity(): ?CommunityEntity
    {
        return $this->community;
    }

    public function setCommunity(?CommunityEntity $community): self
    {
        $this->community = $community;
        return $this;
    }

    #[JMS\VirtualProperty]
    #[JMS\SerializedName("likesCount")]
    #[JMS\Expose]
    public function getLikesCount(): int
    {
        return $this->reactions
            ->filter(fn(CommunityPostReactionEntity $r) => $r->getType() === 'like')
            ->count();
    }
}
