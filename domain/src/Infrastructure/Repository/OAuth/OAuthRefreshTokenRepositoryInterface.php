<?php
namespace Jmondi\Gut\Infrastructure\Repository\OAuth;

use Jmondi\Gut\DomainModel\OAuth\OAuthRefreshToken;

interface OAuthRefreshTokenRepositoryInterface
{
    public function getById(string $oauthRefreshTokenId): OAuthRefreshToken;
    public function create(OAuthRefreshToken & $entity): void;
    public function update(OAuthRefreshToken & $entity): void;
}
