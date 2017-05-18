<?php
namespace Jmondi\Gut\Lib\Command;

use Jmondi\Gut\Lib\MapperInterface;

class CommandBus implements CommandBusInterface
{
    /** @var AuthorizationContextInterface */
    private $authorizationContext;

    /** @var MapperInterface */
    private $mapper;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(
        AuthorizationContextInterface $authorizationContext,
        MapperInterface $mapper,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->authorizationContext = $authorizationContext;
        $this->mapper = $mapper;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param CommandInterface $command
     * @return void
     */
    public function execute(CommandInterface $command)
    {
        $handler = $this->mapper->getCommandHandler($command);
        $handler->verifyAuthorization($this->authorizationContext);
        $handler->handle();
        $this->dispatchEvents($handler);
    }

    private function dispatchEvents(HandlerInterface $handler)
    {
        if ($handler instanceof ReleaseEventsInterface) {
            $this->eventDispatcher->dispatchEvents($handler->releaseEvents());
        }
    }
}
