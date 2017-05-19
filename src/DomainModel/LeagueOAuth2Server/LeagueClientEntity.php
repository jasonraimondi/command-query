<?php

namespace Jmondi\Gut\DomainModel\LeagueOAuth2Server;

use Jmondi\Gut\DomainModel\OAuth\OAuthClient;
use League\OAuth2\Server\Entities\ClientEntityInterface;

class LeagueClientEntity extends OAuthClient implements ClientEntityInterface
{
    public static function createFromOAuthClient(OAuthClient $client): self
    {
        return new self(
            $client->getName(),
            $client->getId()
        );
    }

    /**
     * Get the client's identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getId();
    }

    /**
     * Returns the registered redirect URI (as a string).
     *
     * Alternatively return an indexed array of redirect URIs.
     *
     * @return string|string[]
     */
    public function getRedirectUri()
    {
        return $this->getRedirectUrls();
    }
}
