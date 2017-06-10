<?php
namespace Jmondi\Gut\DomainModel\Exception;

class InvalidFunctionException extends ApplicationException
{
    public static function functionDoesNotExist()
    {
        return new self('Function does not exist.');
    }
}
