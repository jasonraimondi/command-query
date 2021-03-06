<?php
namespace Jmondi\Gut\Infrastructure\Lib\Doctrine;

use Doctrine;
use Jmondi\Gut\DomainModel\Doctrine\Extension\DateTimeIntegerType;
use Jmondi\Gut\DomainModel\Doctrine\Extension\UuidBinaryType;

class DoctrineHelper
{
    protected $eventManager;

    /** @var Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var Doctrine\DBAL\Configuration */
    protected $entityManagerConfiguration;

    /** @var Doctrine\Common\Cache\CacheProvider */
    protected $cacheDriver;

    /** @var Doctrine\DBAL\Configuration */
    protected $config;

    public function __construct(Doctrine\Common\Cache\CacheProvider $cacheDriver = null)
    {
        $paths = [__DIR__ . '/../../../DomainModel'];
        $isDevMode = true;

        $this->config = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $xmlDriver = new Doctrine\ORM\Mapping\Driver\XmlDriver(
            realpath(__DIR__ . '/../../../DomainModel/Doctrine/Mapping')
        );
        $this->config->setMetadataDriverImpl($xmlDriver);
        $this->config->addEntityNamespace('DomainModel', 'Jmondi\Gut\DomainModel');

        if ($cacheDriver !== null) {
            $this->cacheDriver = $cacheDriver;
            $this->config->setMetadataCacheImpl($this->cacheDriver);
            $this->config->setQueryCacheImpl($this->cacheDriver);
            $this->config->setResultCacheImpl($this->cacheDriver);
        }

        $this->eventManager = new Doctrine\Common\EventManager;
    }

    public function clearCache()
    {
        $this->cacheDriver->deleteAll();
    }

    public function getCacheDriver()
    {
        return $this->cacheDriver;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function setSqlLogger(Doctrine\DBAL\Logging\SQLLogger $sqlLogger)
    {
        $this->entityManagerConfiguration->setSQLLogger($sqlLogger);
    }

    public function setup(array $dbParams)
    {
        $this->entityManager = Doctrine\ORM\EntityManager::create($dbParams, $this->config, $this->eventManager);
        $this->entityManagerConfiguration = $this->entityManager->getConnection()->getConfiguration();

        $this->addUuidType();
        $this->addDateTimeIntegerType();
    }

    private function addUuidType()
    {
        $this->setupUuidType();
        $platform = $this->entityManager->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('uuid_binary', 'binary');
    }

    private function setupUuidType()
    {
        static $isAdded = false;
        if (! $isAdded) {
            Doctrine\DBAL\Types\Type::addType('uuid_binary', UuidBinaryType::class);
            $isAdded = true;
        }
    }

    private function addDateTimeIntegerType()
    {
        $this->setupDateTimeIntegerType();
        $platform = $this->entityManager->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('datetime_integer', 'integer');
    }

    private function setupDateTimeIntegerType()
    {
        static $isAdded = false;
        if (! $isAdded) {
            Doctrine\DBAL\Types\Type::addType('datetime_integer', DateTimeIntegerType::class);
            $isAdded = true;
        }
    }
}
