<?php
namespace Jmondi\Gut\Test\Helper\DummyGenerator;

use Jmondi\Gut\DomainModel\User\User;

class UserGenerator
{
    public static function createDummy()
    {
        $user = new User('user@example.com');
        return $user;
    }
}
