<?php
namespace Jmondi\Gut\Infrastructure\Lib\Query;

use Jmondi\Gut\Infrastructure\Autorization\AuthorizationContextInterface;
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

    public function execute(QueryInterface $query): ResponseInterface
    {
        $handler = $this->mapper->getQueryHandler($query);
        $handler->verifyAuthorization($this->authorizationContext);
        return $handler->execute();
    }
}
