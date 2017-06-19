<?php
namespace Jmondi\Gut\Infrastructure\Authorization;

interface AuthorizationContextInterface
{
    /**
     * @throws AuthorizationContextException
     */
    public function verifyIsAuthenticated();
}
