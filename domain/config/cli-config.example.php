<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Jmondi\Gut\Infrastructure\Lib\Doctrine\DoctrineHelper;

require_once __DIR__ . '/../vendor/autoload.php';

$doctrineHelper = new DoctrineHelper(new Doctrine\Common\Cache\ArrayCache());
$doctrineHelper->setup([
    'driver' => 'pdo_mysql',
    'dbname' => 'test',
    'user' => 'root',
    'password' => 'rooty',
    'host' => '127.0.0.1',
    'port' => '4409',
    'charset' => 'utf8',
]);

$entityManager = $doctrineHelper->getEntityManager();

// Fix MySQL enum
$platform = $entityManager->getConnection()->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('enum', 'string');

return ConsoleRunner::createHelperSet($entityManager);
