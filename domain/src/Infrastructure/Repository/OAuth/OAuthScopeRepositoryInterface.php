<?php
namespace Jmondi\Gut\Infrastructure\Repository\OAuth;

use Jmondi\Gut\DomainModel\OAuth\OAuthScope;

interface OAuthScopeRepositoryInterface
{
    public function getById(string $oauthAccessTokenId): OAuthScope;
    public function create(OAuthScope & $entity): void;
    public function update(OAuthScope & $entity): void;
}
