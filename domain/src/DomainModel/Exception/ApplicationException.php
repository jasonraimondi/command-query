<?php
namespace Jmondi\Gut\DomainModel\Exception;

use Exception;
use Jmondi\Gut\DomainModel\Entity\Error\Error;
use Jmondi\Gut\DomainModel\Entity\Error\ErrorCollection;
use JsonSerializable;

class ApplicationException extends Exception implements JsonSerializable
{
    public function __construct($message = '', $statusCode = 500, Exception $previous = null)
    {
        parent::__construct($message, $statusCode, $previous);
    }

    public function jsonSerialize()
    {
        return new ErrorCollection([
            new Error(
                $this->getMessage(),
                basename(self::class),
                $this->getCode()
            )
        ]);
    }
}
