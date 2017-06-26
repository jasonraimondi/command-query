<?php
namespace Jmondi\Gut\Infrastructure\Template\Assets;

class BlankRouteUrlGenerator implements RouteUrlInterface
{
    public function getRoute(string $name, array $parameters = []): string
    {
        return '';
    }
}
