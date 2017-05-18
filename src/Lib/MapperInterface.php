<?php
namespace Jmondi\Gut\Lib;

use Jmondi\Gut\Lib\Command\CommandHandlerInterface;
use Jmondi\Gut\Lib\Command\CommandInterface;
use Jmondi\Gut\Lib\Query\QueryHandlerInterface;
use Jmondi\Gut\Lib\Query\QueryInterface;

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
