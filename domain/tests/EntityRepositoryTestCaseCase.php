<?php
namespace Jmondi\Gut\Test;

use Doctrine;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;
use Jmondi\Gut\Infrastructure\App\DoctrineHelper;

abstract class EntityRepositoryTestCaseCase extends ApplicationTestCase
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
        parent::tearDown();
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
        if (isset($_ENV['DB_NAME'])) {
            $this->setupMysqlConnection();
        } else {
            $this->setupSqliteConnection();
        }
    }

    private function setupMysqlConnection()
    {
        $this->doctrineHelper->setup([
            'driver' => 'pdo_mysql',
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
        ]);
    }
    private function setupSqliteConnection()
    {
        $this->doctrineHelper->setup([
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ]);
        $this->doctrineHelper->addSqliteFunctions();
    }

    protected function getRepositoryFactory()
    {
        return new RepositoryFactory($this->entityManager);
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

    /**
     * @param EntityInterface|EntityInterface[] $entities
     */
    protected function persistEntityAndFlushClear($entities)
    {
        if (! is_array($entities)) {
            $entities = [$entities];
        }

        foreach ($entities as $entity) {
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    protected function executeRepositoryCRUD(RepositoryInterface $repository, EntityInterface $entity)
    {
        $repository->create($entity);
        $repository->update($entity);
        $repository->delete($entity);
    }

    /**
     * @param IdEntityInterface[] $elements
     */
    protected function visitElements($elements)
    {
        foreach ($elements as $e) {
            $e->getId()->toString();
        }
    }

    protected function getInitializeWarehouse()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $this->entityManager->persist($warehouse);
        $this->entityManager->flush();

        return $warehouse;
    }
}
