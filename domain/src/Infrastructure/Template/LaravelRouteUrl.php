<?php
namespace Jmondi\Gut\Infrastructure\Template;

use Jmondi\Gut\DomainModel\Exception\InvalidFunctionException;

class LaravelRouteUrl implements RouteUrlInterface
{
    public function getRoute(string $name, array $parameters = []): string
    {
        if (function_exists('route')) {
            return route($name, $parameters);
        }

        throw InvalidFunctionException::functionDoesNotExist();
    }
}
