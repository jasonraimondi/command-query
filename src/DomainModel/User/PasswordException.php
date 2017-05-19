<?php
namespace Jmondi\Gut\DomainModel\User;

use Jmondi\Gut\DomainModel\Exception\ApplicationException;

class PasswordException extends ApplicationException
{
    public static function invalidAccess()
    {
        return new self('Invalid Access');
    }
}
