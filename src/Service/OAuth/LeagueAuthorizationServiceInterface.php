<?php
namespace Jmondi\Gut\Service\OAuth;

use League\OAuth2\Server\AuthorizationServer;

interface LeagueAuthorizationServiceInterface
{
    public function getAuthorizationServer(): AuthorizationServer;
}