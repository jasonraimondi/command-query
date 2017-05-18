<?php
namespace Jmondi\Gut\Entity\Exception;

class InvalidArgumentException extends ApplicationException
{
    public static function invalidUuid()
    {
        return new self('Invalid Uuid');
    }

    public static function invalidTypeId()
    {
        return new self('Invalid Type Id');
    }
}
