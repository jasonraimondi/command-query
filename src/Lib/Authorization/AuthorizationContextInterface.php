<?php
namespace Jmondi\Gut\Lib\Autorization;

interface AuthorizationContextInterface
{
    /**
     * @throws AuthorizationContextException
     */
    public function verifyIsAdmin();
}
