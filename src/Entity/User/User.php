<?php
namespace Jmondi\Gut\Entity\User;

use Jmondi\Gut\Doctrine\UuidEntityInterface;
use Jmondi\Gut\Entity\DateTime\DateTimeTrait;
use Jmondi\Gut\Entity\Id\UuidEntityTrait;
use Jmondi\Gut\Entity\Uuid\Uuid;
use Jmondi\Gut\Entity\Uuid\UuidInterface;

class User implements UuidEntityInterface
{
    use UuidEntityTrait;
    use DateTimeTrait;

    /** @var string */
    private $email;

    /**
     * @var null|string
     */
    private $password;

    public function __construct(
        string $email,
        ?string $id = null
    ) {
        $this->setId($id);
        $this->setCreatedAt();
        $this->email = $email;
    }

    public function getId(): UuidInterface
    {
        return Uuid::fromString($this->id);
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
