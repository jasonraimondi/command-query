<?php
namespace Jmondi\Gut\DomainModel\Doctrine;

use Jmondi\Gut\DomainModel\Entity\Uuid\UuidInterface;

interface UuidEntityInterface extends EntityInterface
{
    public function getId(): UuidInterface;
}
