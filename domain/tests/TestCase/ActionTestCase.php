<?php
namespace Jmondi\Gut\Test\TestCase;

use Jmondi\Gut\Infrastructure\Authorization\AuthorizationContextInterface;
use Jmondi\Gut\Infrastructure\Lib\Command\CommandBus;
use Jmondi\Gut\Infrastructure\Lib\Command\CommandInterface;
use Jmondi\Gut\Infrastructure\Lib\Mapper\Mapper;
use Jmondi\Gut\Infrastructure\Lib\Mapper\MapperInterface;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryBus;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryInterface;
use Jmondi\Gut\Infrastructure\Lib\Query\ResponseInterface;
use Jmondi\Gut\Test\Helper\AuthorizationContext\AlwaysAuthorizedForTestingAuthorizationContext;

abstract class ActionTestCase extends DummyRepositoryTestCase
{
    protected function dispatchCommand(CommandInterface $command)
    {
        $this->getCommandBus()->execute($command);
    }

    private function getCommandBus(): CommandBus
    {
        return new CommandBus(
            $this->getAuthorizationContext(),
            $this->getMapper()
        );
    }

    private function getAuthorizationContext(): AuthorizationContextInterface
    {
        return new AlwaysAuthorizedForTestingAuthorizationContext();
    }

    protected function getMapper(): Mapper
    {
        return new Mapper(
            $this->getRepositoryFactory(),
            $this->getServiceFactory()
        );
    }

    protected function dispatchQuery(QueryInterface $query): ResponseInterface
    {
        return $this->getQueryBus()->execute($query);
    }

    private function getQueryBus(): QueryBus
    {
        return new QueryBus(
            $this->getAuthorizationContext(),
            $this->getMapper()
        );
    }
}
