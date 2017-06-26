<?php
namespace Jmondi\Gut\DomainModel\Exception;

use Exception;

class NotFoundException extends ApplicationException
{
    public function __construct($message = '', $statusCode = 404, Exception $previous = null)
    {
        parent::__construct($message, $statusCode, $previous);
    }

    public static function themePathNotFound()
    {
        return new self('Theme path not found.');
    }

    public static function twigTemplatePathNotFound()
    {
        return new self('Twig Template path not found');
    }
}
