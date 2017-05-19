<?php
namespace Jmondi\Gut\Infrastructure\Repository\OAuth;

use Jmondi\Gut\DomainModel\OAuth\OAuthClient;

interface OAuthClientRepositoryInterface
{
    public function getById(string $oauthAccessTokenIdentifier): OAuthClient;
    public function create(OAuthClient & $entity): void;
    public function update(OAuthClient & $entity): void;
}
