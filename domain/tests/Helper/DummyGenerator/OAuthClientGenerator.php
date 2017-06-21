<?php
namespace Jmondi\Gut\Test\Helper\DummyGenerator;

use Jmondi\Gut\DomainModel\OAuth\OAuthClient;

class OAuthClientGenerator
{
    public static function createDummy(?string $name = null): OAuthClient
    {
        if ($name === null) {
            $name = 'FakeName';
        }

        $oAuthClient = new OAuthClient($name);

        return $oAuthClient;
    }
}
