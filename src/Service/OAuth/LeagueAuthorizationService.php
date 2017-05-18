<?php
namespace Jmondi\Gut\Service\OAuth;

use DateInterval;
use Jmondi\Gut\Entity\DTO\CertKeyDTO;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\ImplicitGrant;

class LeagueAuthorizationService implements LeagueAuthorizationServiceInterface
{
    /** @var LeagueAccessTokenService */
    private $accessTokenService;
    /** @var LeagueClientService */
    private $clientService;
    /** @var LeagueScopeService */
    private $scopeService;
    /** @var LeagueUserService */
    private $userService;
    /** @var LeagueRefreshTokenService */
    private $refreshTokenService;
    /** @var CertKeyDTO */
    private $certKeyDTO;

    public function __construct(
        LeagueAccessTokenService $accessTokenService,
        LeagueClientService $clientService,
        LeagueScopeService $scopeService,
        LeagueUserService $userService,
        LeagueRefreshTokenService $refreshTokenService,
        CertKeyDTO $certKeyDTO
    ) {
        $this->accessTokenService = $accessTokenService;
        $this->clientService = $clientService;
        $this->scopeService = $scopeService;
        $this->userService = $userService;
        $this->refreshTokenService = $refreshTokenService;
        $this->certKeyDTO = $certKeyDTO;
    }

    public function getAuthorizationServer(): AuthorizationServer
    {
        $authorizationServer = new AuthorizationServer(
            $this->clientService,
            $this->accessTokenService,
            $this->scopeService,
            $this->certKeyDTO->getPrivateKey(),
            $this->certKeyDTO->getPublicKey()
        );

        $authorizationServer->enableGrantType(
            new ImplicitGrant(new DateInterval('PT1H')),
            new DateInterval('PT1H') // access tokens will expire after 1 hour
        );

        return $authorizationServer;
    }
}
