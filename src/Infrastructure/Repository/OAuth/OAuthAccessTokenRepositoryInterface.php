<?php
namespace Jmondi\Gut\Infrastructure\Repository\OAuth;

use Jmondi\Gut\DomainModel\OAuth\OAuthAccessToken;

interface OAuthAccessTokenRepositoryInterface
{
    public function getById(string $oauthAccessTokenId): OAuthAccessToken;
    public function create(OAuthAccessToken & $entity): void;
    public function update(OAuthAccessToken & $entity): void;
}
