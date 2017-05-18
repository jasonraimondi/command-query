<?php
namespace Jmondi\Gut\Entity\LeagueOAuth2Server;

use Jmondi\Gut\Entity\OAuth\OAuthScope;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

class LeagueScopeEntity extends OAuthScope implements ScopeEntityInterface
{
    public static function createFromOAuthScope(OAuthScope $scope)
    {
        return new self(
            $scope->getName(),
            $scope->getId()
        );
    }

    /**
     * Get the scope's identifier.
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getId();
    }
}
