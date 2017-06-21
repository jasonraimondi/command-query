<?php
namespace Jmondi\Gut\DomainModel\Entity\Id;

use Jmondi\Gut\DomainModel\Entity\Uuid\Uuid;
use Jmondi\Gut\DomainModel\Entity\Uuid\UuidInterface;

trait UuidEntityTrait
{
    /** @var UuidInterface */
    protected $id;

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function setId(?string $id)
    {
        if ($id === null) {
            $this->id = Uuid::uuid4();
        } else {
            $this->id = Uuid::fromString($id);
        }
    }

    public function getUuid(): UuidInterface
    {
        return $this->id;
    }

    protected function setUuid(?UuidInterface $id = null)
    {
        if ($id === null) {
            $id = Uuid::uuid4();
        }

        $this->id = $id;
    }
}
