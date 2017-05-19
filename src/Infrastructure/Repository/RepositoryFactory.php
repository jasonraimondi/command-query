<?php
namespace Jmondi\Gut\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Jmondi\Gut\Infrastructure\Repository\OAuth\DoctrineOAuthAccessTokenRepository;
use Jmondi\Gut\Infrastructure\Repository\OAuth\DoctrineOAuthAuthCodeRepository;
use Jmondi\Gut\Infrastructure\Repository\OAuth\DoctrineOAuthClientRepository;
use Jmondi\Gut\Infrastructure\Repository\OAuth\DoctrineOAuthRefreshTokenRepository;
use Jmondi\Gut\Infrastructure\Repository\OAuth\DoctrineOAuthScopeRepository;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthAccessTokenRepositoryInterface;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthAuthCodeRepositoryInterface;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthClientRepositoryInterface;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthRefreshTokenRepositoryInterface;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthScopeRepositoryInterface;
use Jmondi\Gut\Infrastructure\Repository\User\DoctrineUserRepository;
use Jmondi\Gut\Infrastructure\Repository\User\UserRepositoryInterface;

class RepositoryFactory
{
    /** @var EntityManager */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOAuthAccessTokenRepository(): OAuthAccessTokenRepositoryInterface
    {
        return new DoctrineOAuthAccessTokenRepository($this->entityManager);
    }

    public function getOAuthAuthCodeRepository(): OAuthAuthCodeRepositoryInterface
    {
        return new DoctrineOAuthAuthCodeRepository($this->entityManager);
    }

    public function getOAuthClientRepository(): OAuthClientRepositoryInterface
    {
        return new DoctrineOAuthClientRepository($this->entityManager);
    }

    public function getOAuthRefreshTokenRepository(): OAuthRefreshTokenRepositoryInterface
    {
        return new DoctrineOAuthRefreshTokenRepository($this->entityManager);
    }

    public function getOAuthScopeRepository(): OAuthScopeRepositoryInterface
    {
        return new DoctrineOAuthScopeRepository($this->entityManager);
    }

    public function getUserRepository(): UserRepositoryInterface
    {
        return new DoctrineUserRepository($this->entityManager);
    }
}
