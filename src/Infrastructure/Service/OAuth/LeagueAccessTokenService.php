<?php
namespace Jmondi\Gut\Infrastructure\Service\OAuth;

use Jmondi\Gut\DomainModel\OAuth\FormatScopesTrait;
use Jmondi\Gut\DomainModel\OAuth\OAuthAccessToken;
use Jmondi\Gut\DomainModel\OAuth\OAuthAccessTokenException;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthAccessTokenRepositoryInterface;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthClientRepositoryInterface;
use Jmondi\Gut\Infrastructure\Repository\User\UserRepositoryInterface;
use Jmondi\Gut\DomainModel\LeagueOAuth2Server\LeagueAccessTokenEntity;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class LeagueAccessTokenService implements AccessTokenRepositoryInterface
{
    use FormatScopesTrait;

    /** @var OAuthAccessTokenRepositoryInterface */
    private $accessTokenRepository;
    /** @var UserRepositoryInterface */
    private $userRepository;
    /** @var OAuthClientRepositoryInterface */
    private $clientRepository;

    public function __construct(
        OAuthClientRepositoryInterface $clientRepository,
        UserRepositoryInterface $userRepository,
        OAuthAccessTokenRepositoryInterface $accessTokenRepository
    ) {
        $this->accessTokenRepository = $accessTokenRepository;
        $this->userRepository = $userRepository;
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param ClientEntityInterface $clientEntity
     * @param ScopeEntityInterface[] $scopes
     * @param string $userId
     * @return AccessTokenEntityInterface
     * @throws OAuthAccessTokenException
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userId = null)
    {
        $user = $this->userRepository->getById($userId);
        $client = $this->clientRepository->getById($clientEntity->getIdentifier());
        return LeagueAccessTokenEntity::createFromOAuthAccessToken(new OAuthAccessToken($user, $client));
    }

    /**
     * @param AccessTokenEntityInterface $accessTokenEntity
     * @throws OAuthAccessTokenException
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $user = $this->userRepository->getById($accessTokenEntity->getUserIdentifier());
        $client = $this->clientRepository->getById($accessTokenEntity->getClient()->getIdentifier());
        $oAuthAccessToken = new OAuthAccessToken($user, $client, $accessTokenEntity->getIdentifier());
        $this->accessTokenRepository->create($oAuthAccessToken);
    }

    /**
     * @param string $tokenId
     */
    public function revokeAccessToken($tokenId)
    {
        $accessToken = $this->accessTokenRepository->getById($tokenId);
        $accessToken->revoke();
        $this->accessTokenRepository->update($accessToken);
    }

    /**
     * @param string $tokenId
     * @return bool Return true if this token has been revoked
     */
    public function isAccessTokenRevoked($tokenId)
    {
        $accessToken = $this->accessTokenRepository->getById($tokenId);
        return $accessToken->isRevoked();
    }
}
