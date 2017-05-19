<?php
namespace Jmondi\Gut\DomainModel\OAuth;

use Jmondi\Gut\DomainModel\Exception\ApplicationException;

class OAuthAccessTokenException extends ApplicationException
{
    public function __construct($message = '', $code = 403, \Exception $previous = null, $exceptionData = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function expiredAccessToken()
    {
        return new self('Expired access token');
    }

    public static function revokedAccessToken()
    {
        return new self('Revoked access token');
    }

    public static function incorrectEntityType()
    {
        return new self('Incorrect Entity Type');
    }
}
