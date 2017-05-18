<?php
namespace Jmondi\Gut\Repository;

use Doctrine\ORM\EntityManager;
use Jmondi\Gut\Repository\OAuth\DoctrineOAuthAccessTokenRepository;
use Jmondi\Gut\Repository\OAuth\DoctrineOAuthAuthCodeRepository;
use Jmondi\Gut\Repository\OAuth\DoctrineOAuthClientRepository;
use Jmondi\Gut\Repository\OAuth\DoctrineOAuthRefreshTokenRepository;
use Jmondi\Gut\Repository\OAuth\DoctrineOAuthScopeRepository;
use Jmondi\Gut\Repository\OAuth\OAuthAccessTokenRepositoryInterface;
use Jmondi\Gut\Repository\OAuth\OAuthAuthCodeRepositoryInterface;
use Jmondi\Gut\Repository\OAuth\OAuthClientRepositoryInterface;
use Jmondi\Gut\Repository\OAuth\OAuthRefreshTokenRepositoryInterface;
use Jmondi\Gut\Repository\OAuth\OAuthScopeRepositoryInterface;
use Jmondi\Gut\Repository\User\DoctrineUserRepository;
use Jmondi\Gut\Repository\User\UserRepositoryInterface;

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
