<?php
namespace Jmondi\Gut\Repository;

use Doctrine\ORM\EntityRepository;
use Jmondi\Gut\Entity\Uuid\UuidInterface;
use Jmondi\Gut\Doctrine\EntityInterface;
use Jmondi\Gut\Entity\Exception\EntityNotFoundException;

abstract class AbstractRepository extends EntityRepository implements RepositoryInterface
{
    use EntityValidationTrait;

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return new QueryBuilder($this->getEntityManager());
    }

    public function create(EntityInterface & $entity)
    {
        $this->persist($entity);
        $this->flush();
    }

    public function update(EntityInterface & $entity)
    {
        $this->assertManaged($entity);
        $this->throwValidationErrors($entity);
        $this->flush();
    }

    public function delete(EntityInterface $entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->flush();
    }

    public function persist(EntityInterface & $entity)
    {
        $this->throwValidationErrors($entity);
        $this->getEntityManager()
            ->persist($entity);
    }

    public function flush()
    {
        $this->getEntityManager()->flush();
    }

    protected function returnOrThrowNotFoundException($entity, $className = null)
    {
        if ($entity === null) {
            throw $this->getEntityNotFoundException($className);
        }

        return $entity;
    }

    protected function getEntityNotFoundException($className = null)
    {
        if ($className === null) {
            $className = $this->getClassName();
        }

        return new EntityNotFoundException($className . ' not found');
    }

    private function assertManaged(EntityInterface $entity)
    {
        if (! $this->getEntityManager()->contains($entity)) {
            throw $this->getEntityNotFoundException();
        }
    }
}
