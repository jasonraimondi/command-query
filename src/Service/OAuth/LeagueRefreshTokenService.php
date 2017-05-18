<?php
namespace Jmondi\Gut\Service\OAuth;

use Jmondi\Gut\Entity\OAuth\OAuthAccessTokenException;
use Jmondi\Gut\Entity\OAuth\OAuthRefreshToken;
use Jmondi\Gut\Entity\LeagueOAuth2Server\LeagueRefreshTokenEntity;
use Jmondi\Gut\Repository\OAuth\OAuthRefreshTokenRepositoryInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

class LeagueRefreshTokenService implements RefreshTokenRepositoryInterface
{
    /** @var OAuthRefreshTokenRepositoryInterface */
    private $refreshTokenRepository;

    public function __construct(
        OAuthRefreshTokenRepositoryInterface $refreshTokenRepository
    ) {
        $this->refreshTokenRepository = $refreshTokenRepository;
    }

    /**
     * Creates a new refresh token
     * @return RefreshTokenEntityInterface
     */
    public function getNewRefreshToken()
    {
        return new LeagueRefreshTokenEntity();
    }

    /**
     * @param RefreshTokenEntityInterface $refreshTokenEntity
     * @throws OAuthAccessTokenException
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        if ($refreshTokenEntity instanceof OAuthRefreshToken) {
            $this->refreshTokenRepository->create($refreshTokenEntity);
        } else {
            throw OAuthAccessTokenException::incorrectEntityType();
        }
    }

    /**
     * @param string $tokenId
     */
    public function revokeRefreshToken($tokenId): void
    {
        $refreshToken = $this->refreshTokenRepository->getById($tokenId);
        $refreshToken->revoke();
        $this->refreshTokenRepository->update($refreshToken);
    }

    /**
     * @param string $tokenId
     * @return bool
     */
    public function isRefreshTokenRevoked($tokenId): bool
    {
        $refreshToken = $this->refreshTokenRepository->getById($tokenId);
        return ! $refreshToken->isValid();
    }
}
