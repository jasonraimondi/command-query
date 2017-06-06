<?php
namespace Jmondi\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Jmondi\Gut\Infrastructure\Lib\ApplicationCore;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ApplicationCore::class, function ($app) {
            return new ApplicationCore(
                [
                    'driver' => 'pdo_mysql',
                    'dbname' => getenv('MYSQL_DATABASE') ?: 'jmondi',
                    'user' => 'root',
                    'password' => getenv('MYSQL_PASSWORD') ?: 'secret',
                    'host' => getenv('MYSQL_HOST') ?: 'mysql',
                    'port' => getenv('MYSQL_PORT') ?: '3306',
                    'charset' => 'utf8',
                ]
            );
        });
    }
}
