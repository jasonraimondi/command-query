<?php
namespace Jmondi\Gut\Entity\Exception;

use Exception;

class EntityNotFoundException extends ApplicationException
{
    public function __construct($message = '', $code = 404, Exception $previous = null, $exceptionData = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function entityNotManaged($entity)
    {
        $entityName = get_class($entity);
        return new self('Entity (' . $entityName . ') not managed');
    }

    public static function user()
    {
        return new self('User not found');
    }

    public static function oauthAccessToken()
    {
        return new self('OAuthAccessToken not found');
    }

    public static function oauthClient()
    {
        return new self('OAuthClient not found');
    }

    public static function oauthAuthCode()
    {
        return new self('OAuthAuthCode not found');
    }

    public static function oauthRefreshToken()
    {
        return new self('OAuthRefreshToken not found');
    }

    public static function oauthScope()
    {
        return new self('OAuthScope not found');
    }
}
