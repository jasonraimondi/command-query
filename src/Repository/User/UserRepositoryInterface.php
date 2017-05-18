<?php
namespace Jmondi\Gut\Repository\User;

use Jmondi\Gut\Entity\Uuid\UuidInterface;
use Jmondi\Gut\Entity\User\User;

interface UserRepositoryInterface
{
    public function getById(UuidInterface $userId): User;
    public function getByEmail(string $email): User;
    public function create(User & $entity): void;
    public function update(User & $entity): void;
}
