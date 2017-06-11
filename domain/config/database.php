<?php

return [
    'driver' => 'pdo_mysql',
    'dbname' => getenv('MYSQL_DATABASE') ?: 'jmondi',
    'user' => 'root',
    'password' => getenv('MYSQL_PASSWORD') ?: 'secret',
    'host' => getenv('MYSQL_HOST') ?: 'mysql',
    'port' => getenv('MYSQL_PORT') ?: '3306',
    'charset' => 'utf8',
];
