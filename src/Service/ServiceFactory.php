<?php
namespace Jmondi\Gut\Service;

use Jmondi\Gut\Entity\DTO\CertKeyDTO;
use Jmondi\Gut\Repository\RepositoryFactory;
use Jmondi\Gut\Service\OAuth\LeagueAccessTokenService;
use Jmondi\Gut\Service\OAuth\LeagueAuthorizationService;
use Jmondi\Gut\Service\OAuth\LeagueClientService;
use Jmondi\Gut\Service\OAuth\LeagueRefreshTokenService;
use Jmondi\Gut\Service\OAuth\LeagueScopeService;
use Jmondi\Gut\Service\OAuth\LeagueUserService;

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
