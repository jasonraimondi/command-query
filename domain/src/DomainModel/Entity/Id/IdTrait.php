<?php
namespace Jmondi\Gut\DomainModel\Entity\Id;

use Jmondi\Gut\DomainModel\Entity\Uuid\Uuid;

trait IdTrait
{
    protected function setId(?string $id = null)
    {
        if ($id === null) {
            $id = Uuid::uuid4()->toString();
        }

        $this->id = $id;
    }
}
