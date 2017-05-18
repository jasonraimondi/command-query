<?php
namespace Jmondi\Gut\Lib\Action;

use Jmondi\Gut\Lib\Autorization\AuthorizationContextException;
use Jmondi\Gut\Lib\Autorization\AuthorizationContextInterface;
use Jmondi\Gut\Lib\Query\ResponseInterface;

interface HandlerInterface
{
    /**
     * @param AuthorizationContextInterface $authorizationContext
     * @return void
     * @throws AuthorizationContextException
     */
    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext);

    /**
     * @return ResponseInterface
     */
    public function execute();
}
