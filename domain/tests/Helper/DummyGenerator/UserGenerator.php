<?php
namespace Jmondi\Gut\Test\Helper\DummyGenerator;

use Jmondi\Gut\DomainModel\User\User;

class UserGenerator
{
    public static function createDummy(): User
    {
        $user = new User('user@example.com');
        $user->setPassword('fakePassword');
        return $user;
    }
}
