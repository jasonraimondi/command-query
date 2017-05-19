<?php
namespace Jmondi\Gut\DomainModel\OAuth;

use Jmondi\Gut\DomainModel\Doctrine\EntityInterface;
use Jmondi\Gut\DomainModel\Doctrine\StringEntityInterface;
use Jmondi\Gut\DomainModel\Entity\DateTime\CreatedAtTrait;
use Jmondi\Gut\DomainModel\Entity\Id\UuidEntityTrait;

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
