<?php
namespace Jmondi\Gut\Infrastructure\Lib\Mapper;

use Jmondi\Gut\Infrastructure\Lib\Action\ActionInterface;
use Jmondi\Gut\Infrastructure\Lib\Command\CommandInterface;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryInterface;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthAccessTokenRepositoryInterface;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthAuthCodeRepositoryInterface;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthClientRepositoryInterface;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthRefreshTokenRepositoryInterface;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthScopeRepositoryInterface;
use Jmondi\Gut\Infrastructure\Repository\User\UserRepositoryInterface;
use Jmondi\Gut\Infrastructure\Repository\RepositoryFactory;
use Jmondi\Gut\Infrastructure\Service\ServiceFactory;
use ReflectionClass;

class Mapper implements MapperInterface
{
    /** @var RepositoryFactory */
    private $repositoryFactory;

    /** @var ServiceFactory */
    private $serviceFactory;

    public function __construct(
        RepositoryFactory $repositoryFactory,
        ServiceFactory $serviceFactory
    ) {
        $this->repositoryFactory = $repositoryFactory;
        $this->serviceFactory = $serviceFactory;
    }

    public function getCommandHandler(CommandInterface $command)
    {
        $handlerClassName = $this->getCommandHandlerClassName($command);
        return $this->getHandler($handlerClassName, $command);
    }

    public function getQueryHandler(QueryInterface $query)
    {
        $handlerClassName = $this->getQueryHandlerClassName($query);
        return $this->getHandler($handlerClassName, $query);
    }

    /**
     * @param string $handlerClassName
     * @param ActionInterface
     * @return null|object
     */
    public function getHandler($handlerClassName, $action)
    {
        $reflection = new ReflectionClass($handlerClassName);

        $constructorParameters = [];
        $constructor = $reflection->getConstructor();
        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $key => $parameter) {
                if ($key === 0 && $action instanceof ActionInterface) {
                    $constructorParameters[] = $action;
                    continue;
                }

                $parameterClassName = $parameter->getClass()->getName();

                if ($parameterClassName === OAuthAccessTokenRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getOAuthAccessTokenRepository();
                } elseif ($parameterClassName === OAuthAuthCodeRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getOAuthAuthCodeRepository();
                } elseif ($parameterClassName === OAuthClientRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getOAuthClientRepository();
                } elseif ($parameterClassName === OAuthRefreshTokenRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getOAuthRefreshTokenRepository();
                } elseif ($parameterClassName === OAuthScopeRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getOAuthScopeRepository();
                } elseif ($parameterClassName === UserRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getUserRepository();
                }
            }
        }

        $handler = null;

        if (! empty($constructorParameters)) {
            $handler = $reflection->newInstanceArgs($constructorParameters);
        } else {
            $handler = $reflection->newInstance();
        }

        return $handler;
    }

    /**
     * @param CommandInterface $command
     * @return string
     */
    private function getCommandHandlerClassName($command)
    {
        $className = get_class($command);
        $className = str_replace('\\Action\\', '\\ActionHandler\\', $className);
        $pieces = explode('\\', $className);

        $baseName = array_pop($pieces);
        $handlerBaseName = $baseName . 'Handler';
        $pieces[] = $handlerBaseName;

        return implode('\\', $pieces);
    }

    /**
     * @param QueryInterface
     * @return string
     */
    private function getQueryHandlerClassName($query)
    {
        $className = get_class($query);
        $className = str_replace('\\Action\\', '\\ActionHandler\\', $className);
        $pieces = explode('\\', $className);

        $baseName = array_pop($pieces);
        $handlerBaseName = $baseName . 'Handler';

        $pieces[] = $handlerBaseName;

        return implode('\\', $pieces);
    }
}
