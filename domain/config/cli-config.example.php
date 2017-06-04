<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Jmondi\Gut\Infrastructure\Lib\Doctrine\DoctrineHelper;

require_once __DIR__ . '/../vendor/autoload.php';

$doctrineHelper = new DoctrineHelper(new Doctrine\Common\Cache\ArrayCache());
$doctrineHelper->setup([
    'driver' => 'pdo_mysql',
    'dbname' => getenv('MYSQL_DATABASE') ?: 'jmondi',
    'user' => getenv('MYSQL_USER') ?: 'user',
    'password' => getenv('MYSQL_PASSWORD') ?: 'secret',
    'host' => getenv('MYSQL_HOST') ?: 'mysql',
    'port' => getenv('MYSQL_PORT') ?: '3306',
    'charset' => 'utf8mb4',
]);

$entityManager = $doctrineHelper->getEntityManager();

// Fix MySQL enum
$platform = $entityManager->getConnection()->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('enum', 'string');

return ConsoleRunner::createHelperSet($entityManager);
