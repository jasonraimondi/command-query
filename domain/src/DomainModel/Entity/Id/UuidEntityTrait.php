<?php
namespace Jmondi\Gut\DomainModel\Entity\Id;

use Jmondi\Gut\DomainModel\Entity\Uuid\Uuid;
use Jmondi\Gut\DomainModel\Entity\Uuid\UuidInterface;

trait UuidEntityTrait
{
    /** @var string */
    protected $id;

    public function getUuid(): UuidInterface
    {
        return Uuid::fromString($this->id);
    }

    protected function setId(?string $id = null)
    {
        if ($id === null) {
            $id = Uuid::uuid4()->toString();
        }

        $this->id = $id;
    }
}
