<?php
namespace Jmondi\Gut\Repository\OAuth;

use Jmondi\Gut\Entity\OAuth\OAuthClient;

interface OAuthClientRepositoryInterface
{
    public function getById(string $oauthAccessTokenIdentifier): OAuthClient;
    public function create(OAuthClient & $entity): void;
    public function update(OAuthClient & $entity): void;
}
