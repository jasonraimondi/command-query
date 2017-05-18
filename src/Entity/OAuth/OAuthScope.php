<?php
namespace Jmondi\Gut\Entity\OAuth;

use Jmondi\Gut\Doctrine\EntityInterface;
use Jmondi\Gut\Doctrine\StringEntityInterface;
use Jmondi\Gut\Entity\DateTime\CreatedAtTrait;
use Jmondi\Gut\Entity\Id\UuidEntityTrait;

class OAuthScope implements StringEntityInterface
{
    use UuidEntityTrait;
    use CreatedAtTrait;

    /** @var string */
    private $name;

    public function __construct(
        string $name,
        ?string $id = null
    ) {
        $this->setId($id);
        $this->setCreatedAt();
        $this->name = $name;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

}
