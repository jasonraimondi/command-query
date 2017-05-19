<?php
namespace Jmondi\Gut\Infrastructure\Lib\Query;

use Jmondi\Gut\Infrastructure\Lib\Autorization\AuthorizationContextInterface;
use Jmondi\Gut\Infrastructure\Lib\MapperInterface;

class QueryBus implements QueryBusInterface
{
    /** @var AuthorizationContextInterface */
    private $authorizationContext;

    /** @var MapperInterface */
    private $mapper;

    public function __construct(
        AuthorizationContextInterface $authorizationContext,
        MapperInterface $mapper
    ) {
        $this->authorizationContext = $authorizationContext;
        $this->mapper = $mapper;
    }

    /**
     * @param QueryInterface $query
     * @return ResponseInterface
     */
    public function execute(QueryInterface $query)
    {
        $handler = $this->mapper->getQueryHandler($query);
        $handler->verifyAuthorization($this->authorizationContext);
        return $handler->handle();
    }
}
