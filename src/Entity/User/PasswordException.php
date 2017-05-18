<?php
namespace Jmondi\Gut\Entity\User;

use Jmondi\Gut\Entity\Exception\ApplicationException;

class PasswordException extends ApplicationException
{
    public static function invalidAccess()
    {
        return new self('Invalid Access');
    }
}
