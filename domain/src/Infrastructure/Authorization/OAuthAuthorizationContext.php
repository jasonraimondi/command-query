<?php
namespace Jmondi\Gut\Infrastructure\Authorization;

use Jmondi\Gut\DomainModel\OAuth\OAuthAccessToken;
use Jmondi\Gut\Infrastructure\Authorization\AuthorizationContextException;
use Jmondi\Gut\Infrastructure\Authorization\AuthorizationContextInterface;

class OAuthAuthorizationContext implements AuthorizationContextInterface
{
    /** @var OAuthAccessToken */
    private $oAuthAccessToken;

    public function __construct(OAuthAccessToken $oAuthAccessToken)
    {
        $this->oAuthAccessToken = $oAuthAccessToken;
    }

    /**
     * @throws AuthorizationContextException
     */
    public function verifyIsAuthenticated()
    {
        if (! $this->oAuthAccessToken->isValid()) {
            throw AuthorizationContextException::accessDenied();
        }
    }

}
