<?php
namespace Jmondi\Gut\Repository\OAuth;

use Jmondi\Gut\Entity\OAuth\OAuthScope;

interface OAuthScopeRepositoryInterface
{
    public function getById(string $oauthAccessTokenId): OAuthScope;
    public function create(OAuthScope & $entity): void;
    public function update(OAuthScope & $entity): void;
}
