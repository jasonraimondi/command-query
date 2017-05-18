<?php
namespace Jmondi\Gut\Repository\OAuth;

use Jmondi\Gut\Entity\OAuth\OAuthAccessToken;

interface OAuthAccessTokenRepositoryInterface
{
    public function getById(string $oauthAccessTokenId): OAuthAccessToken;
    public function create(OAuthAccessToken & $entity): void;
    public function update(OAuthAccessToken & $entity): void;
}
