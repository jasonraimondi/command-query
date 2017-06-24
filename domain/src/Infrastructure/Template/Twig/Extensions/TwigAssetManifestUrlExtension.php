<?php
namespace Jmondi\Gut\Infrastructure\Template\Twig\Extensions;

use Jmondi\Gut\Infrastructure\Template\AssetLocationService;
use Jmondi\Gut\Infrastructure\Template\Exceptions\TemplateAssetException;
use Jmondi\Gut\Infrastructure\Template\RouteUrlInterface;
use Twig_Extension;
use Twig_SimpleFunction;

class TwigAssetManifestUrlExtension extends Twig_Extension
{
    /** @var RouteUrlInterface */
    private $routeUrl;

    public function __construct(RouteUrlInterface $routeUrl)
    {
        $this->routeUrl = $routeUrl;
    }

    public function getName()
    {
        return 'assetManifestUrl';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'assetManifestUrl',
                [$this, 'assetManifestUrl']
            ),
        ];
    }

    public function assetManifestUrl(string $templateNamespace, string $path): string
    {
        if ($templateNamespace[0] !== '@') {
            throw TemplateAssetException::namespaceTemplatePrefix();
        }

        $assetLocationService = new AssetLocationService();
        $assetManifest = $assetLocationService->getTemplateManifest($templateNamespace)[$path] ?? $path;

        return $this->routeUrl->getRoute(
            'asset.serve',
            [
                'templateNamespace' => urlencode($templateNamespace),
                'path' => urlencode($assetManifest),
            ]
        );
    }
}
