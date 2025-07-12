<?php

namespace App\Core\Persistence\Repository;

use App\Core\Persistence\Entity\EntityInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\UnitOfWork;

abstract class AbstractRepository extends EntityRepository implements EntityRepositoryInterface
{
//    private SearchContext $context;

    public function isEntityPersisted (EntityInterface $entity): bool
    {
        return UnitOfWork::STATE_MANAGED === $this->getEntityManager()->getUnitOfWork()->getEntityState($entity);
    }

    protected function join(QueryBuilder $queryBuilder, string $join, string $alias, $conditionType = null, $condition = null, $indexBy = null): QueryBuilder {
        if ($this->canJoin($queryBuilder, $alias)) {
            $queryBuilder->join($join, $alias, $conditionType, $condition, $indexBy);
        }
        return $queryBuilder;
    }

    protected function leftJoin(QueryBuilder $queryBuilder, string $join, string $alias, $conditionType = null, $condition = null, $indexBy = null): QueryBuilder {
        if ($this->canJoin($queryBuilder, $alias)) {
            $queryBuilder->leftJoin($join, $alias, $conditionType, $condition, $indexBy);
        }
        return $queryBuilder;
    }

    protected function canJoin(QueryBuilder $queryBuilder, string $alias): bool {
        $joinDqlParts = $queryBuilder->getDQLParts();
        $canJoin = true;

        foreach ($joinDqlParts['join'] as $joins) {
            /**
             * @var Join $join
             */
            foreach ($joins as $join) {
                if ($join->getAlias() === $alias) {
                    $canJoin = false;
                    break 2;
                }
            }
        }
        return $canJoin;
    }

    public function remove (EntityInterface $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }

    public function save(EntityInterface $entity, bool $flush = true): EntityInterface
    {
        $this->persist($entity);
        if($flush) {
            $this->flush();
        }
        return $entity;
    }

    public function persist(EntityInterface $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function getQueryBuilder(?string $type = null): QueryBuilder
    {
        return $this->createQueryBuilder($this->getEntityAlias());
    }

//    public function setContext(SearchContext $context): self
//    {
//        $this->context = $context;
//        return $this;
//    }
//
//    public function getContext(): SearchContext
//    {
//        return $this->context;
//    }


}
