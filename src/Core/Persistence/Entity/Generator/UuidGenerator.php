<?php

namespace App\Core\Persistence\Entity\Generator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Component\Uid\Uuid;

final class UuidGenerator extends AbstractIdGenerator
{
    public function __construct()
    {
    }


    public function generate(EntityManager $em, $entity): Uuid
    {
        return $this->generateId($em, $entity);
    }

    public function generateId(EntityManagerInterface $em, $entity): Uuid
    {
        if (method_exists($entity, 'getId') && null !== $entity->getId()) {
            return $entity->getId();
        }
        return Uuid::v4();
    }
}
