<?php
namespace Jmondi\Gut\Infrastructure\Service\OAuth;

use League\OAuth2\Server\AuthorizationServer;

interface LeagueAuthorizationServiceInterface
{
    public function getAuthorizationServer(): AuthorizationServer;
}