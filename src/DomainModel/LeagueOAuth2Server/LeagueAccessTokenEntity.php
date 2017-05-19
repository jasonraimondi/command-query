<?php
namespace Jmondi\Gut\DomainModel\LeagueOAuth2Server;

use DateTime;
use Jmondi\Gut\DomainModel\OAuth\OAuthAccessToken;
use Jmondi\Gut\DomainModel\OAuth\OAuthAccessTokenException;
use Jmondi\Gut\DomainModel\OAuth\OAuthClient;
use Jmondi\Gut\DomainModel\OAuth\OAuthScope;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

class LeagueAccessTokenEntity extends OAuthAccessToken implements AccessTokenEntityInterface
{
    public static function createFromOAuthAccessToken(OAuthAccessToken $token): self
    {
        return new self(
            $token->getUser(),
            $token->getOAuthClient(),
            $token->getId()
        );
    }

    public static function createOAuthAccessTokenFromEntity(
        LeagueAccessTokenEntity $accessTokenEntity
    ): OAuthAccessToken {
        return new OAuthAccessToken(
            $accessTokenEntity->getUser(),
            $accessTokenEntity->getOAuthClient(),
            $accessTokenEntity->getId()
        );
    }

    /**
     * Generate a JWT from the access token
     * @param CryptKey $privateKey
     * @return string
     */
    public function convertToJWT(CryptKey $privateKey)
    {
        return (new Builder())
            ->setAudience($this->getClient()->getIdentifier())
            ->setId($this->getIdentifier(), true)
            ->setIssuedAt(time())
            ->setNotBefore(time())
            ->setExpiration($this->getExpiryDateTime()->getTimestamp())
            ->setSubject($this->getUserIdentifier())
            ->set('scopes', $this->getScopes())
            ->sign(new Sha256(), new Key($privateKey->getKeyPath(), $privateKey->getPassPhrase()))
            ->getToken();
    }

    /**
     * Get the token's identifier.
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getId();
    }

    /**
     * Get the token's expiry date time.
     * @return DateTime
     */
    public function getExpiryDateTime()
    {
        return $this->getExpiresAt();
    }

    /**
     * Set the date time when the token expires.
     * @param DateTime $expiresAt
     */
    public function setExpiryDateTime(DateTime $expiresAt)
    {
        $this->setExpiresAt($expiresAt);
    }

    /**
     * Set the identifier of the user associated with the token.
     *
     * @param string|int $user The identifier of the user
     */
    public function setUserIdentifier($user)
    {
        // @TODO leaving this one blank for now because of the issues it raises being a string instead of user entity.
    }

    /**
     * Get the token user's identifier.
     * @return string|int
     */
    public function getUserIdentifier()
    {
        return $this->getUser()->getId();
    }

    /**
     * Set the token's identifier.
     * @param $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->setIdentifierToken($identifier);
    }

    /**
     * Get the client that the token was issued to.
     *
     * @return ClientEntityInterface
     */
    public function getClient()
    {
        return $this->getOAuthClient();
    }

    /**
     * Set the client that the token was issued to.
     *
     * @param ClientEntityInterface $client
     */
    public function setClient(ClientEntityInterface $client)
    {
        if ($client instanceof OAuthClient) {
            $this->setOAuthClient($client);
        } else {
            OAuthAccessTokenException::incorrectEntityType();
        }
    }

    /**
     * Associate a scope with the token.
     * @param ScopeEntityInterface $scope
     * @throws OAuthAccessTokenException
     */
    public function addScope(ScopeEntityInterface $scope)
    {
        if ($scope instanceof OAuthScope) {
            $this->addOAuthScope($scope);
        } else {
            throw OAuthAccessTokenException::incorrectEntityType();
        }
    }

    /**
     * Return an array of scopes associated with the token.
     *
     * @return ScopeEntityInterface[]
     */
    public function getScopes()
    {
        // @TODO
        return [];
    }
}
