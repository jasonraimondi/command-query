<?php
namespace Jmondi\Gut\Infrastructure\Template\Twig;

class TwigExtension extends \Twig_Extension
{
    public function __construct(RouteU«rlInterface $routeUrl)
    {
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', [$this, 'assetUrl']),
        );
    }

    public function assetUrl($theme, $section, $path)
    {
        return $this->routeUrl->getRoute(
            'asset.serve',
            [
                'theme' => $theme,
                'section' => $section,
                'path' => $path,
            ]
        );
    }
}
