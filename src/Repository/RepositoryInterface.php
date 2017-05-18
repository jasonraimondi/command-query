<?php
namespace Jmondi\Gut\Repository;

use Jmondi\Gut\Entity\Uuid\UuidInterface;
use Jmondi\Gut\Doctrine\EntityInterface;
use Jmondi\Gut\Entity\Exception\EntityNotFoundException;

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
