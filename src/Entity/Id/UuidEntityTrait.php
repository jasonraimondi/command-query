<?php
namespace Jmondi\Gut\Entity\Id;

use Ramsey\Uuid\Uuid;

trait UuidEntityTrait
{
    /** @var string */
    private $id;

    protected function setId(?string $id = null)
    {
        if ($id === null) {
            $id = Uuid::uuid4()->toString();
        }

        $this->id = $id;
    }
}
