<?php
namespace Jmondi\Gut\Infrastructure\Lib\Action;

use Jmondi\Gut\Infrastructure\Autorization\AuthorizationContextException;
use Jmondi\Gut\Infrastructure\Autorization\AuthorizationContextInterface;
use Jmondi\Gut\Infrastructure\Lib\Query\ResponseInterface;

interface HandlerInterface
{
    /**
     * @param AuthorizationContextInterface $authorizationContext
     * @return void
     * @throws AuthorizationContextException
     */
    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext);

    /** @return ResponseInterface */
    public function execute();
}
