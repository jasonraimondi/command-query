<?php
namespace Jmondi\Gut\Repository\OAuth;

use Jmondi\Gut\Entity\OAuth\OAuthRefreshToken;

interface OAuthRefreshTokenRepositoryInterface
{
    public function create(OAuthRefreshToken & $entity): void;
    public function update(OAuthRefreshToken & $entity): void;
}
