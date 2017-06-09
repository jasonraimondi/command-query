<?php
namespace Jmondi\Gut\Infrastructure\Template\Twig;

use Jmondi\Gut\Infrastructure\Template\RouteUrlInterface;

class LaravelRouteUrl implements RouteUrlInterface
{
    public function getRoute(string $name, array $parameters = []): string
    {
        return route($name, $parameters);
    }
}
