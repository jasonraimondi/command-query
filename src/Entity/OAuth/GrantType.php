<?php
namespace Jmondi\Gut\Entity\OAuth;

use Jmondi\Gut\Entity\Type\AbstractStringType;
use Jmondi\Gut\Entity\Type\TypeDetail;

class GrantType extends AbstractStringType
{
    protected const CLIENT_CREDENTIALS = 'client-credentials';
    protected const PASSWORD = 'password';
    protected const IMPLICIT = 'implicit';
    protected const AUTHORIZATION_CODE = 'authorization-code';
    protected const REFRESH_TOKEN = 'refresh-token';

    public static function getTypeDetails(): array
    {
        return [
            new TypeDetail(
                self::clientCredentials(),
                self::CLIENT_CREDENTIALS,
                'Client Credentials',
                'This grant is suitable for machine-to-machine authentication, for example for use in a cron job which '
                . 'is performing maintenance tasks over an API. Another example would be a client making requests to an'
                . ' API that don’t require user’s permission.'
            ),
            new TypeDetail(
                self::password(),
                self::PASSWORD,
                'Password',
                'This grant is a great user experience for trusted first party clients both on the web and in native '
                . 'applications.'
            ),
            new TypeDetail(
                self::implicit(),
                self::IMPLICIT,
                'Implicit',
                'The authorization code grant should be very familiar if you’ve ever signed into a web app using your '
                . 'Facebook or Google account.'
            ),
            new TypeDetail(
                self::authorizationCode(),
                self::AUTHORIZATION_CODE,
                'Authorization Code',
                'The implicit grant is similar to the authorization code grant with two distinct differences. '
                . 'It is intended to be used for user-agent-based clients (e.g. single page web apps) that can’t keep '
                . 'a client secret because all of the application code and storage is easily accessible. Secondly '
                . 'instead of the authorization server returning an authorization code which is exchanged for an '
                . 'access token, the authorization server returns an access token.'
            ),
            new TypeDetail(
                self::refreshToken(),
                self::REFRESH_TOKEN,
                'Refresh Token',
                'Access tokens eventually expire; however some grants respond with a refresh token which enables the '
                . 'client to refresh the access token.'
            ),
        ];
    }

    private static function clientCredentials()
    {
        return new self(self::CLIENT_CREDENTIALS);
    }

    public static function password()
    {
        return new self(self::PASSWORD);
    }

    public static function implicit()
    {
        return new self(self::IMPLICIT);
    }

    private static function authorizationCode()
    {
        return new self(self::AUTHORIZATION_CODE);
    }

    private static function refreshToken()
    {
        return new self(self::REFRESH_TOKEN);
    }

    public function isClientCredentials()
    {
        return $this->is(self::CLIENT_CREDENTIALS);
    }

    public function isPassword()
    {
        return $this->is(self::PASSWORD);
    }

    public function isImplicit()
    {
        return $this->is(self::IMPLICIT);
    }

    public function isAuthorizationCode()
    {
        return $this->is(self::AUTHORIZATION_CODE);
    }

    public function isRefreshToken()
    {
        return $this->is(self::REFRESH_TOKEN);
    }

    public function jsonSerialize() : array
    {
        return array_merge(
            parent::jsonSerialize(),
            [
                'isClientCredentials' => $this->isClientCredentials(),
                'isPassword' => $this->isPassword(),
                'isImplicit' => $this->isImplicit(),
                'isAuthorizationCode' => $this->isAuthorizationCode(),
                'isRefreshToken' => $this->isRefreshToken(),
            ]
        );
    }
}
