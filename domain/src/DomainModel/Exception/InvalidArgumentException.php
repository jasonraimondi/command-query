<?php
namespace Jmondi\Gut\DomainModel\Exception;

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
