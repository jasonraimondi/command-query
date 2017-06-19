<?php
namespace Jmondi\Gut\Tests\Helper\AuthorizationContext;

use Jmondi\Gut\Infrastructure\Authorization\AuthorizationContextException;
use Jmondi\Gut\Infrastructure\Authorization\AuthorizationContextInterface;

class AlwaysAuthorizedForTestingAuthorizationContext implements AuthorizationContextInterface
{
    /**
     * @throws AuthorizationContextException
     */
    public function verifyIsAuthenticated()
    {
        // TODO: Implement verifyIsAuthenticated() method.
    }
}
