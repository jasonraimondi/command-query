<?php
namespace Jmondi\Gut\Repository\OAuth;

use Jmondi\Gut\Entity\OAuth\OAuthAuthCode;

interface OAuthAuthCodeRepositoryInterface
{
    public function getById(string $oauthAccessTokenId): OAuthAuthCode;
    public function create(OAuthAuthCode & $entity): void;
    public function update(OAuthAuthCode & $entity): void;
}
