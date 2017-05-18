<?php
namespace Jmondi\Gut\Doctrine;

use Jmondi\Gut\Entity\Uuid\UuidInterface;

interface UuidEntityInterface extends EntityInterface
{
    public function getId(): UuidInterface;
}
