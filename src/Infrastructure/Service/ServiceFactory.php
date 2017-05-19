<?php
namespace Jmondi\Gut\Infrastructure\Service;

use Jmondi\Gut\DomainModel\Entity\DTO\CertKeyDTO;
use Jmondi\Gut\Infrastructure\Repository\RepositoryFactory;
use Jmondi\Gut\Infrastructure\Service\OAuth\LeagueAccessTokenService;
use Jmondi\Gut\Infrastructure\Service\OAuth\LeagueAuthorizationService;
use Jmondi\Gut\Infrastructure\Service\OAuth\LeagueClientService;
use Jmondi\Gut\Infrastructure\Service\OAuth\LeagueRefreshTokenService;
use Jmondi\Gut\Infrastructure\Service\OAuth\LeagueScopeService;
use Jmondi\Gut\Infrastructure\Service\OAuth\LeagueUserService;

class ServiceFactory
{
    /** @var RepositoryFactory */
    protected $repositoryFactory;

    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->repositoryFactory = $repositoryFactory;
    }

    public function getOAuthService(): LeagueAuthorizationService
    {
        return new LeagueAuthorizationService(
            $this->getLeagueOAuthAccessTokenService(),
            $this->getLeagueOAuthClientService(),
            $this->getLeagueOAuthScopeService(),
            $this->getLeagueOAuthUserService(),
            $this->getLeagueOAuthRefreshTokenService(),
            new CertKeyDTO(
                'file://' . realpath(__DIR__ . '/../../') . '/certs/private.key',
                'file://' . realpath(__DIR__ . '/../../') . '/certs/public.key'
            )
        );
    }

    public function getLeagueOAuthAccessTokenService(): LeagueAccessTokenService
    {
        return new LeagueAccessTokenService(
            $this->repositoryFactory->getOAuthClientRepository(),
            $this->repositoryFactory->getUserRepository(),
            $this->repositoryFactory->getOAuthAccessTokenRepository()
        );
    }

    public function getLeagueOAuthClientService(): LeagueClientService
    {
        return new LeagueClientService(
            $this->repositoryFactory->getOAuthClientRepository()
        );
    }

    public function getLeagueOAuthRefreshTokenService(): LeagueRefreshTokenService
    {
        return new LeagueRefreshTokenService(
            $this->repositoryFactory->getOAuthRefreshTokenRepository()
        );
    }

    public function getLeagueOAuthScopeService(): LeagueScopeService
    {
        return new LeagueScopeService(
            $this->repositoryFactory->getOAuthScopeRepository()
        );
    }

    public function getLeagueOAuthUserService(): LeagueUserService
    {
        return new LeagueUserService(
            $this->repositoryFactory->getUserRepository()
        );
    }
}
