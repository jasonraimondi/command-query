<?php
namespace Jmondi\Gut\Infrastructure\Template\Twig\Extensions;

use Jmondi\Gut\Infrastructure\Template\Exceptions\TemplateAssetException;
use Jmondi\Gut\Infrastructure\Template\RouteUrlInterface;
use Twig_Extension;
use Twig_SimpleFunction;

class TwigRouteUrlExtension extends Twig_Extension
{
    /** @var RouteUrlInterface */
    private $routeUrl;

    public function __construct(RouteUrlInterface $routeUrl)
    {
        $this->routeUrl = $routeUrl;
    }

    public function getName()
    {
        return 'routeUrl';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'routeUrl',
                [$this, 'routeUrl']
            ),
        ];
    }

    public function routeUrl(string $name, array $parameters = []): string
    {
        return $this->routeUrl->getRoute($name, $parameters);
    }
}
