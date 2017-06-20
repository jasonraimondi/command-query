<?php
namespace Jmondi\Gut\Infrastructure\Lib\Query;

use Jmondi\Gut\Infrastructure\Authorization\AuthorizationContextInterface;
use Jmondi\Gut\Infrastructure\Lib\Mapper\MapperInterface;

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
        var_dump($mapper);
        die();
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
