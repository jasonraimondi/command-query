<?php
namespace Jmondi\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Jmondi\Gut\Infrastructure\Lib\ApplicationCore;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ApplicationCore::class, function ($app) {
            return ApplicationCore::createMysqlConnection();
        });
    }
}
