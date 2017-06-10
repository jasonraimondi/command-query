<?php
namespace Jmondi\Gut\Infrastructure\Template\Twig;

use Jmondi\Gut\Infrastructure\Template\RouteUrlInterface;

class BlankRouteUrlGenerator implements RouteUrlInterface
{
    public function getRoute(string $name, array $parameters = []): string
    {
        return '';
    }
}
