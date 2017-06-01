<?php
namespace Jmondi\Gut\Infrastructure\Repository\User;

use Jmondi\Gut\DomainModel\User\User;

interface UserRepositoryInterface
{
    public function getById(string $userId): User;
    public function getByEmail(string $email): User;
    public function create(User & $entity): void;
    public function update(User & $entity): void;
}
