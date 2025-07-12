<?php

namespace App\Service;

use App\Core\Persistence\Repository\EntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractManager
{
    public function __construct(
        private EntityManagerInterface $em,
    )
    {

    }

    public function getEntityRepository(string $entityClass): EntityRepositoryInterface
    {
        return $this->em->getRepository($entityClass);
    }

}
