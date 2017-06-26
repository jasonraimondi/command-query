<?php
namespace Jmondi\Gut\Infrastructure\Template\Assets;

interface RouteUrlInterface
{
    public function getRoute(string $name, array $parameters = []): string;
}
