<?php

namespace Jmondi\Gut\Infrastructure\Template\Twig;

use Jmondi\Gut\Infrastructure\Template\LeagueCommonMark\MarkdownParser;
use Jmondi\Gut\Infrastructure\Template\RouteUrlInterface;
use Jmondi\Gut\Infrastructure\Template\Twig\Extensions\TwigAssetManifestUrlExtension;
use Jmondi\Gut\Infrastructure\Template\Twig\Extensions\TwigAssetUrlExtension;
use Jmondi\Gut\Infrastructure\Template\Twig\Extensions\TwigMarkdownExtension;
use Jmondi\Gut\Infrastructure\Template\Twig\Extensions\TwigRouteUrlExtension;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigTemplateGenerator
{
    /** @var Twig_Environment */
    private $twigEnvironment;
    /** @var Twig_Loader_Filesystem */
    private $twigLoader;
    /** @var array|TemplateNamespace[] */
    private $twigTemplateNamespaces;
    /** @var RouteUrlInterface */
    private $routeUrl;

    public static function createTemplateGenerator(RouteUrlInterface $routeUrl)
    {
        return new self([
            TemplateNamespace::createFromNamespace('_base'),
            TemplateNamespace::createFromNamespace('auth'),
            TemplateNamespace::createFromNamespace('client-libs'),
            TemplateNamespace::createFromNamespace('frontend'),
        ], $routeUrl);
    }

    /**
     * @param TemplateNamespace[] $twigTemplateNamespaces
     * @param RouteUrlInterface $routeUrl
     */
    private function __construct(array $twigTemplateNamespaces, RouteUrlInterface $routeUrl)
    {
        $this->twigLoader = new Twig_Loader_Filesystem();
        $this->twigEnvironment = new Twig_Environment($this->twigLoader);
        $this->twigTemplateNamespaces = $twigTemplateNamespaces;
        $this->routeUrl = $routeUrl;
        $this->addTwigExtensions();
        $this->addTwigTemplateNamespaces();
    }

    public function getTwigEnvironment()
    {
        return $this->twigEnvironment;
    }

    private function addTwigExtensions()
    {
        $this->twigEnvironment->setExtensions($this->getAllExtensions());
    }

    private function addTwigTemplateNamespaces()
    {
        foreach ($this->twigTemplateNamespaces as $templateNamespace) {
            $this->twigLoader->addPath(
                $templateNamespace->getTemplatesPath(),
                $templateNamespace->getNamespace()
            );
        }
    }

    private function getAllExtensions(): array
    {
        return [
            new TwigMarkdownExtension(MarkdownParser::createFromNothing()),
            new TwigAssetUrlExtension($this->routeUrl),
            new TwigAssetManifestUrlExtension($this->routeUrl),
            new TwigRouteUrlExtension($this->routeUrl),
        ];
    }
}
