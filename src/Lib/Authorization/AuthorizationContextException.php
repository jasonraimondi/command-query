<?php
namespace Jmondi\Gut\Lib\Autorization;

use Exception;
use Jmondi\Gut\Entity\Exception\ApplicationException;

class AuthorizationContextException extends ApplicationException
{
    public function __construct($message = '', $code = 403, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function accessDenied()
    {
        return new self('Access denied');
    }
}
