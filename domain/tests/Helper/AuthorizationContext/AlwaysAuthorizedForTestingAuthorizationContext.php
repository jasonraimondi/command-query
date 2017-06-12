<?php
namespace Jmondi\Gut\Test\Helper\AuthorizationContext;

use Jmondi\Gut\Infrastructure\Autorization\AuthorizationContextInterface;

class AlwaysAuthorizedForTestingAuthorizationContext implements AuthorizationContextInterface
{
    public function verifyIsAuthenticated()
    {
    }
}
