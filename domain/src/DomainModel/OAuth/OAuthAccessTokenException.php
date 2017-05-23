<?php
namespace Jmondi\Gut\DomainModel\OAuth;

use Jmondi\Gut\DomainModel\Exception\ApplicationException;

class OAuthAccessTokenException extends ApplicationException
{
    public function __construct($message = '', $code = 403, \Exception $previous = null, $exceptionData = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function expired()
    {
        return new self('Expired OAuthAccessToken');
    }

    public static function revoked()
    {
        return new self('Revoked OAuthAccessToken');
    }
}
