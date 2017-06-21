<?php
namespace Jmondi\Gut\Test\Helper\DummyGenerator;

use Jmondi\Gut\DomainModel\OAuth\OAuthAccessToken;
use Jmondi\Gut\DomainModel\OAuth\OAuthClient;
use Jmondi\Gut\DomainModel\User\User;

class OAuthAccessTokenGenerator
{
    public static function createDummy(User $user, OAuthClient $oAuthClient): OAuthAccessToken
    {
        $accessToken = new OAuthAccessToken(
            $user,
            $oAuthClient
        );
        return $accessToken;
    }
}
