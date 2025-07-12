<?php

namespace App\Service;

use App\Core\Exception\NotFoundException;
use App\Core\Persistence\Entity\EntityInterface;
use App\Core\Persistence\Repository\EntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractManager
{
    public function __construct(
        private EntityManagerInterface $em,
    )
    {

    }

    /**
     * @throws NotFoundException
     */
    protected function getEntityById(string $entityClass, string $id): EntityInterface
    {
        $result = $this->getEntityRepository($entityClass)->find($id);

        if (!$result) {
            throw new NotFoundException(['Entity with ID [%s] not found', $id]);
        }
        return $result;
    }

    public function getEntityRepository(string $entityClass): EntityRepositoryInterface
    {
        return $this->em->getRepository($entityClass);
    }

}
