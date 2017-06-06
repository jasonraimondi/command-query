<?php
namespace Jmondi\Gut\Infrastructure\Lib;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;
use Jmondi\Gut\DomainModel\OAuth\OAuthAccessToken;
use Jmondi\Gut\DomainModel\OAuth\OAuthAccessTokenException;
use Jmondi\Gut\Infrastructure\Authorization\OAuthAuthorizationContext;
use Jmondi\Gut\Infrastructure\Lib\Command\CommandBus;
use Jmondi\Gut\Infrastructure\Lib\Command\CommandBusInterface;
use Jmondi\Gut\Infrastructure\Lib\Command\CommandInterface;
use Jmondi\Gut\Infrastructure\Lib\Doctrine\DoctrineHelper;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryBus;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryBusInterface;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryInterface;
use Jmondi\Gut\Infrastructure\Lib\Query\ResponseInterface;
use Jmondi\Gut\Infrastructure\Repository\RepositoryFactory;
use Jmondi\Gut\Infrastructure\Service\ServiceFactory;

final class ApplicationCore
{
    /** @var array */
    private $doctrineDbParams;
    /** @var null|OAuthAccessToken */
    private $oAuthAccessToken;
    /** @var null|ArrayCache */
    private $cacheDriver;
    /** @var EntityManager */
    private $entityManager;
    /** @var null|RepositoryFactory */
    private $repositoryFactory;
    /** @var null|ServiceFactory */
    private $serviceFactory;

    public function __construct(array $doctrineDbParams)
    {
        $this->doctrineDbParams = $doctrineDbParams;
    }

    public function dispatchCommand(CommandInterface $command): void
    {
        $this->getCommandBus()->execute($command);
    }

    public function dispatchQuery(QueryInterface $query): ResponseInterface
    {
        return $this->getQueryBus()->execute($query);
    }

    public function getServiceFactory(): ServiceFactory
    {
        if ($this->serviceFactory === null) {
            $this->serviceFactory = new ServiceFactory(
                $this->getRepositoryFactory()
            );
        }
        return $this->serviceFactory;
    }

    public function getRepositoryFactory()
    {
        if ($this->repositoryFactory === null) {
            $this->repositoryFactory = new RepositoryFactory(
                $this->getEntityManager()
            );
        }
        return $this->repositoryFactory;
    }

    private function getCommandBus(): CommandBusInterface
    {
        static $commandBus = null;
        if ($commandBus === null) {
            $commandBus = new CommandBus(
                $this->getAuthorizationContext(),
                $this->getMapper()
            );
        }
        return $commandBus;
    }

    private function getQueryBus(): QueryBusInterface
    {
        static $queryBus = null;
        if ($queryBus === null) {
            $queryBus = new QueryBus(
                $this->getAuthorizationContext(),
                $this->getMapper()
            );
        }
        return $queryBus;
    }

    private function getMapper(): MapperInterface
    {
        static $mapper = null;
        if ($mapper === null) {
            $mapper = new Mapper(
                $this->getRepositoryFactory(),
                $this->getServiceFactory()
            );
        }
        return $mapper;
    }

    private function getEntityManager()
    {
        if ($this->entityManager === null) {
            $cacheDriver = $this->getCacheDriver();
            $doctrineHelper = new DoctrineHelper($cacheDriver);
            $doctrineHelper->setup($this->doctrineDbParams);

            $this->entityManager = $doctrineHelper->getEntityManager();
        }
        return $this->entityManager;
    }

    private function getAuthorizationContext()
    {
        return new OAuthAuthorizationContext(
            $this->getOAuthAccessToken()
        );
    }

    private function setOAuthAccessToken(string $oAuthAccessTokenId): void
    {
        $oAuthAccessToken = $this->getRepositoryFactory()
            ->getOAuthAccessTokenRepository()
            ->getById($oAuthAccessTokenId);

        if ($oAuthAccessToken->isExpired()) {
            throw OAuthAccessTokenException::expired();
        }

        if ($oAuthAccessToken->isRevoked()) {
            throw OAuthAccessTokenException::revoked();
        }

        if ($oAuthAccessToken->isValid()) {
            throw OAuthAccessTokenException::invalidOrNullAccessToken();
        }

        $this->oAuthAccessToken = $oAuthAccessToken;
    }

    private function getOAuthAccessToken(): OAuthAccessToken
    {
        if ($this->oAuthAccessToken === null) {
            throw OAuthAccessTokenException::invalidOrNullAccessToken();
        }

        return $this->oAuthAccessToken;
    }

    private function getCacheDriver()
    {
        if ($this->cacheDriver === null) {
            $this->cacheDriver = new ArrayCache();
        }
        return $this->cacheDriver;
    }
}
