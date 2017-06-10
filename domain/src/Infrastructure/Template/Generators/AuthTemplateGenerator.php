<?php
namespace Jmondi\Gut\Infrastructure\Template\Generators;

use Jmondi\Gut\Infrastructure\Template\RouteUrlInterface;
use Jmondi\Gut\Infrastructure\Template\Twig\TemplateNamespace;

final class AuthTemplateGenerator extends AbstractTemplateGenerator
{
    public function __construct(RouteUrlInterface $routeUrl)
    {
        parent::__construct(TemplateNamespace::auth(), $routeUrl);
    }
}
