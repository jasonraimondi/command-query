<?php
namespace Jmondi\Gut\Test\TestCase;

use Doctrine;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;
use Jmondi\Gut\DomainModel\Doctrine\EntityInterface;
use Jmondi\Gut\Infrastructure\Lib\Doctrine\DoctrineHelper;
use Jmondi\Gut\Infrastructure\Repository\RepositoryFactory;
use Jmondi\Gut\Infrastructure\Service\ServiceFactory;
use Jmondi\Gut\Test\Helper\Logger\CountSQLLogger;

abstract class RepositoryTestCase extends ApplicationTestCase
{
    /** @var EntityManager */
    protected $entityManager;

    /** @var DoctrineHelper */
    protected $doctrineHelper;

    /** @var CountSQLLogger */
    protected $countSQLLogger;

    /** @var string[] */
    protected $metaDataClassNames;

    public function setUp()
    {
        if ($this->metaDataClassNames !== null) {
            $this->setupEntityManager();
        }

        parent::setUp();
    }

    protected function tearDown()
    {
        if ($this->entityManager !== null) {
            $this->entityManager->getConnection()->close();
        }
    }

    protected function setupEntityManager($metaDataClassNames = null)
    {
        if ($metaDataClassNames !== null) {
            $this->metaDataClassNames = $metaDataClassNames;
        }

        $this->getConnection();
        $this->setupTestSchema();
    }

    private function getConnection()
    {
        $this->doctrineHelper = new DoctrineHelper(new ArrayCache());
        $this->setupDatabaseConnection();

        $this->entityManager = $this->doctrineHelper->getEntityManager();
    }

    private function setupDatabaseConnection()
    {
        if (false) {
            $this->setupMysqlConnection();
        } else {
            $this->setupSqliteConnection();
        }
    }

    private function setupMysqlConnection()
    {
        $this->doctrineHelper->setup([
            'driver' => 'pdo_mysql',
            'dbname' => getenv('MYSQL_DATABASE') ?: 'jmondi',
            'user' => 'root',
            'password' => getenv('MYSQL_PASSWORD') ?: 'secret',
            'host' => getenv('MYSQL_HOST') ?: 'mysql',
            'port' => getenv('MYSQL_PORT') ?: '3306',
            'charset' => 'utf8',
        ]);
    }

    private function setupSqliteConnection()
    {
        $this->doctrineHelper->setup([
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ]);
    }

    protected function getRepositoryFactory()
    {
        return new RepositoryFactory($this->entityManager);
    }

    protected function getServiceFactory(): ServiceFactory
    {
        return new ServiceFactory(
            $this->getRepositoryFactory()
        );
    }

    private function setupTestSchema()
    {
        if ($this->metaDataClassNames === null) {
            $classes = $this->entityManager->getMetaDataFactory()->getAllMetaData();
        } else {
            $classes = [];
            foreach ($this->metaDataClassNames as $className) {
                $classes[] = $this->entityManager->getMetaDataFactory()->getMetadataFor($className);
            }
        }

        $tool = new Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $tool->dropSchema($classes);
        $tool->createSchema($classes);
    }

    public function setEchoLogger()
    {
        $this->doctrineHelper->setSqlLogger(new Doctrine\DBAL\Logging\EchoSQLLogger);
    }

    public function setCountLogger($enableDisplay = false)
    {
        $this->countSQLLogger = new CountSQLLogger($enableDisplay);
        $this->doctrineHelper->setSqlLogger($this->countSQLLogger);
    }

    public function getTotalQueries()
    {
        return $this->countSQLLogger->getTotalQueries();
    }

    protected function beginTransaction()
    {
        $this->entityManager->getConnection()->beginTransaction();
    }

    protected function rollback()
    {
        $this->entityManager->getConnection()->rollback();
    }


    protected function assertEntitiesEqual(EntityInterface $entity1, EntityInterface $entity2)
    {
        if (! $entity1->getId() === $entity2->getId()) {
            $this->fail(
                'Failed asserting entities ARE equal:' . PHP_EOL .
                get_class($entity1) . ': ' . $entity1->getId() . PHP_EOL .
                get_class($entity2) . ': ' . $entity2->getId()
            );
        } else {
            $this->assertSame($entity1->getId(), $entity2->getId());
        }
    }

    protected function assertEntitiesNotEqual(EntityInterface $entity1, EntityInterface $entity2)
    {
        if ($entity1->getId() === $entity2->getId()) {
            $this->fail(
                'Failed asserting entities NOT equal:' . PHP_EOL .
                get_class($entity1) . ': ' . $entity1->getId() . PHP_EOL .
                get_class($entity2) . ': ' . $entity2->getId()
            );
        }
    }

    /**
     * @param EntityInterface $expectedEntity
     * @param EntityInterface[] $entities
     */
    protected function assertEntityInArray(EntityInterface $expectedEntity, array $entities)
    {
        $this->assertTrue($this->isEntityInArray($expectedEntity, $entities));
    }

    /**
     * @param EntityInterface $expectedEntity
     * @param EntityInterface[] $entities
     * @return bool
     */
    protected function isEntityInArray(EntityInterface $expectedEntity, array $entities): bool
    {
        foreach ($entities as $entity) {
            if ($expectedEntity->getId() === $entity->getId()) {
                return true;
            }
        }

        return false;
    }
}
