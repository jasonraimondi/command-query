<?php
namespace Jmondi\Gut\Test\Helper\DummyGenerator;

use Jmondi\Gut\DomainModel\OAuth\OAuthClient;
use Jmondi\Gut\DomainModel\OAuth\OAuthRefreshToken;
use Jmondi\Gut\DomainModel\User\User;

class OAuthRefreshTokenGenerator
{
    public static function createDummy(User $user, OAuthClient $oAuthClient): OAuthRefreshToken
    {
        $accessToken = new OAuthRefreshToken();
        return $accessToken;
    }
}
