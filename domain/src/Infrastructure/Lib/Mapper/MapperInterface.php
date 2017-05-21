<?php
namespace Jmondi\Gut\Infrastructure\Lib;

use Jmondi\Gut\Infrastructure\Lib\Command\CommandHandlerInterface;
use Jmondi\Gut\Infrastructure\Lib\Command\CommandInterface;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryHandlerInterface;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryInterface;

interface MapperInterface
{
    /**
     * @param CommandInterface $command
     * @return CommandHandlerInterface
     */
    public function getCommandHandler(CommandInterface $command);

    /**
     * @param QueryInterface $query
     * @return QueryHandlerInterface
     */
    public function getQueryHandler(QueryInterface $query);
}
