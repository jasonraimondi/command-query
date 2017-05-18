<?php
namespace Jmondi\Gut\Entity\LeagueOAuth2Server;

use DateTime;
use Jmondi\Gut\Entity\OAuth\OAuthAccessToken;
use Jmondi\Gut\Entity\OAuth\OAuthAccessTokenException;
use Jmondi\Gut\Entity\OAuth\OAuthRefreshToken;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

class LeagueRefreshTokenEntity extends OAuthRefreshToken implements RefreshTokenEntityInterface
{
    public static function createFromOAuthRefreshToken(OAuthRefreshToken $token): self
    {
        return new self(
            $token->getOAuthAccessToken()
        );
    }

    /**
     * Get the token's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getId();
    }

    /**
     * Set the access token that the refresh token was associated with.
     *
     * @param AccessTokenEntityInterface $accessToken
     * @throws OAuthAccessTokenException
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken)
    {
        if ($accessToken instanceof OAuthAccessToken) {
            $this->setOAuthAccessToken($accessToken);
        } else {
            throw OAuthAccessTokenException::incorrectEntityType();
        }
    }

    /**
     * Get the access token that the refresh token was originally associated with.
     *
     * @return AccessTokenEntityInterface
     */
    public function getAccessToken()
    {
        return new LeagueAccessTokenEntity(
            $this->getOAuthAccessToken()->getUser(),
            $this->getOAuthAccessToken()->getOAuthClient()
        );
    }

    /**
     * Get the token's expiry date time.
     *
     * @return DateTime
     */
    public function getExpiryDateTime()
    {
        return $this->getExpiresAt();
    }

    /**
     * Set the date time when the token expires.
     *
     * @param DateTime $dateTime
     */
    public function setExpiryDateTime(DateTime $dateTime)
    {
        $this->setExpiresAt($dateTime);
    }

    /**
     * Set the token's identifier.
     * @param $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->setIdentifierToken($identifier);
    }
}
