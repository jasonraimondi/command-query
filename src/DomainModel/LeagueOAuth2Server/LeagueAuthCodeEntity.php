<?php
namespace Jmondi\Gut\DomainModel\LeagueOAuth2Server;

use DateTime;
use Jmondi\Gut\DomainModel\OAuth\OAuthAuthCode;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

class LeagueAuthCodeEntity extends OAuthAuthCode implements AuthCodeEntityInterface
{
    public static function createFromOAuthAuthCode(OAuthAuthCode $authCode)
    {
        return new self(
            $authCode->getUser(),
            $authCode->getOAuthClient(),
            $authCode->getId()
        );
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
     * Set the token's identifier.
     * @param $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->setIdentifierToken($identifier);
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
     * @param string|int $user The identifier of the user
     */
    public function setUserIdentifier($user)
    {
        // @TODO leaving this one blank for now because of the issues it raises being a string instead of user entity.
    }

    /**
     * Get the token user's identifier.
     *
     * @return string|int
     */
    public function getUserIdentifier()
    {
        return $this->getUser()->getId();
    }

    public function setRedirectUri($redirectUrl)
    {
        $this->setRedirectUrl($redirectUrl);
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->getRedirectUrl();
    }

    /**
     * Set the client that the token was issued to.
     *
     * @param ClientEntityInterface $client
     */
    public function setClient(ClientEntityInterface $client)
    {
        $this->setOAuthClient($client);
    }

    /**
     * Get the client that the token was issued to.
     *
     * @return ClientEntityInterface
     */
    public function getClient()
    {
        // TODO: Implement getClient() method.
    }

    /**
     * Associate a scope with the token.
     *
     * @param ScopeEntityInterface $scope
     */
    public function addScope(ScopeEntityInterface $scope)
    {
        $this->addOAuthScope($scope);
    }

    /**
     * Return an array of scopes associated with the token.
     *
     * @return ScopeEntityInterface[]
     */
    public function getScopes()
    {
        return $this->getOAuthScopes();
    }
}
