<?php
namespace Jmondi\Gut\DomainModel\User;

use Jmondi\Gut\DomainModel\Doctrine\UuidEntityInterface;
use Jmondi\Gut\DomainModel\Entity\DateTime\DateTimeTrait;
use Jmondi\Gut\DomainModel\Entity\Id\UuidEntityTrait;

class User implements UuidEntityInterface
{
    use UuidEntityTrait;
    use DateTimeTrait;

    /** @var string */
    private $email;
    /** @var null|string */
    private $password;

    public function __construct(
        string $email,
        ?string $id = null
    ) {
        $this->setId($id);
        $this->setCreatedAt();
        $this->email = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function isValidPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function jsonSerialize(): array
    {
        return [
            'email' => $this->email,
        ];
    }
}
