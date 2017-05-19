<?php
namespace Jmondi\Gut\Infrastructure\Lib\Autorization;

interface AuthorizationContextInterface
{
    /**
     * @throws AuthorizationContextException
     */
    public function verifyIsAdmin();
}
