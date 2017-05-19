<?php
namespace Jmondi\Gut\Infrastructure\Repository\OAuth;

use Jmondi\Gut\DomainModel\OAuth\OAuthAuthCode;

interface OAuthAuthCodeRepositoryInterface
{
    public function getById(string $oauthAccessTokenId): OAuthAuthCode;
    public function create(OAuthAuthCode & $entity): void;
    public function update(OAuthAuthCode & $entity): void;
}
