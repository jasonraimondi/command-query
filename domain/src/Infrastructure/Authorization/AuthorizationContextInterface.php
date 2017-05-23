<?php
namespace Jmondi\Gut\Infrastructure\Autorization;

interface AuthorizationContextInterface
{
    /**
     * @throws AuthorizationContextException
     */
    public function verifyIsAuthenticated();
}
