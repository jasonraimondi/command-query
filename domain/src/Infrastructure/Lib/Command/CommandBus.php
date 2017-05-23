<?php
namespace Jmondi\Gut\Infrastructure\Lib\Command;

use Jmondi\Gut\Infrastructure\Autorization\AuthorizationContextInterface;
use Jmondi\Gut\Infrastructure\Lib\MapperInterface;

class CommandBus implements CommandBusInterface
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
     * @param CommandInterface $command
     * @return void
     */
    public function execute(CommandInterface $command): void
    {
        $handler = $this->mapper->getCommandHandler($command);
        $handler->verifyAuthorization($this->authorizationContext);
        $handler->execute();
    }
}
