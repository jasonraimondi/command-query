<?php
namespace Jmondi\Gut\Infrastructure\Template\Twig\Extension;

use Jmondi\Gut\Infrastructure\Template\RouteUrlInterface;
use Twig_Extension;
use Twig_SimpleFunction;

class TwigAssetUrlExtension extends Twig_Extension
{
    /** @var RouteUrlInterface */
    private $routeUrl;

    public function __construct(RouteUrlInterface $routeUrl)
    {
        $this->routeUrl = $routeUrl;
    }

    public function getName()
    {
        return 'assetUrl';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'assetUrl',
                [$this, 'assetUrl']
            ),
        ];
    }

    public function assetUrl(string $templateNamespace, string $path): string
    {
        if ($templateNamespace[0] !== '@') {
            throw TemplateAssetException::namespaceTemplatePrefix();
        }

        return $this->routeUrl->getRoute(
            'asset.serve',
            [
                'templateNamespace' => urlencode($templateNamespace),
                'path' => urlencode($path),
            ]
        );
    }

    /**
     * @param string $templateNamespace
     * @return bool|string
     */
    private function removeAtSymbol(string $templateNamespace)
    {
        $templateNamespace = substr($templateNamespace, 1);
        return $templateNamespace;
    }
}
