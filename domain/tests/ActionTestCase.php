<?php
namespace Jmondi\Gut\Test;

use Jmondi\Gut\Infrastructure\Lib\Command\CommandBus;
use Jmondi\Gut\Infrastructure\Lib\Command\CommandInterface;
use Jmondi\Gut\Infrastructure\Lib\Mapper;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryBus;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryInterface;

abstract class ActionTestCase extends EntityRepositoryTestCaseCase
{
    protected function dispatchCommand(CommandInterface $command)
    {
        $this->getCommandBus()->execute($command);
    }

    /**
     * @param QueryInterface $query
     * @return ResponseInterface
     */
    protected function dispatchQuery(QueryInterface $query)
    {
        return $this->getQueryBus()->execute($query);
    }

    private function getCommandBus()
    {
        return new CommandBus(
            $this->getAuthorizationContext(),
            $this->getMapper()
        );
    }

    private function getQueryBus()
    {
        return new QueryBus(
            $this->getAuthorizationContext(),
            $this->getMapper()
        );
    }

    protected function getMapper()
    {
        return new Mapper(
            $this->getRepositoryFactory(),
            $this->getServiceFactory()
        );
    }

    private function getAuthorizationContext()
    {
        return new AlwaysAuthorizedForTestingAuthorizationContext();
    }
}