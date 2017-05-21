<?php
namespace Jmondi\Gut\Infrastructure\Repository;

use Jmondi\Gut\DomainModel\Entity\Uuid\UuidInterface;
use Jmondi\Gut\DomainModel\Doctrine\EntityInterface;
use Jmondi\Gut\DomainModel\Exception\EntityNotFoundException;

interface RepositoryInterface
{
    public function create(EntityInterface & $entity);
    public function update(EntityInterface & $entity);
    public function delete(EntityInterface & $entity);

    /**
     * @param UuidInterface $id
     * @return EntityInterface
     * @throws EntityNotFoundException
     */
    public function getById(UuidInterface $id);
}
