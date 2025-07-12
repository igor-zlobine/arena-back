<?php

namespace App\Core\Persistence\Entity\Trait;

use App\Core\Dto\Trait\IdTrait;
use App\Core\Persistence\Entity\Generator\UuidGenerator;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

trait EntityTrait
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: "uuid")]
    private $id;
}