<?php
namespace Jmondi\Gut\Lib\Command;

interface CommandBusInterface
{
    /**
     * @param CommandInterface $command
     * @return void
     */
    public function execute(CommandInterface $command);
}
