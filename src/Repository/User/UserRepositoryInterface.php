<?php
namespace Jmondi\Gut\Repository\User;

use Jmondi\Gut\Entity\User\User;

interface UserRepositoryInterface
{
    public function getById(): User;
}