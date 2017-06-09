<?php
namespace Jmondi\Gut\Infrastructure\Template;

interface RouteUrlInterface
{
    public function getRoute(string $name, array $parameters = []): string;
}
