<?php

namespace Jmondi\Gut\Infrastructure\Template\Twig;

use Jmondi\Gut\Infrastructure\Template\LeagueCommonMark\MarkdownParser;
use Jmondi\Gut\Infrastructure\Template\RouteUrlInterface;
use Jmondi\Gut\Infrastructure\Template\Twig\Extension\TwigAssetUrlExtension;
use Jmondi\Gut\Infrastructure\Template\Twig\Extension\TwigLowercaseFirstExtension;
use Jmondi\Gut\Infrastructure\Template\Twig\Extension\TwigMarkdownExtension;
use Twig_Environment;
use Twig_Extension;
use Twig_Loader_Filesystem;

class TwigTemplateGenerator
{
    /** @var Twig_Environment */
    private $twigEnvironment;
    /** @var Twig_Loader_Filesystem */
    private $twigLoader;

    public static function createTemplateGenerator(RouteUrlInterface $routeUrl)
    {
        return new self([
            TemplateNamespace::auth(),
            TemplateNamespace::clientLibs(),
        ], $routeUrl);
    }

    /**
     * @param TemplateNamespace[] $twigTemplateNamespaces
     */
    private function __construct(array $twigTemplateNamespaces, RouteUrlInterface $routeUrl)
    {
        $this->twigLoader = new Twig_Loader_Filesystem();

        foreach ($twigTemplateNamespaces as $templateNamespace) {
            $this->addTwigTemplatePath($templateNamespace);
        }

        $this->twigEnvironment = new Twig_Environment($this->twigLoader);

        $this->addTwigExtensions([
            new TwigMarkdownExtension(MarkdownParser::createFromNothing()),
            new TwigLowercaseFirstExtension(),
            new TwigAssetUrlExtension($routeUrl)
        ]);

    }

    public function getTwigEnvironment()
    {
        return $this->twigEnvironment;
    }

    /**
     * @param Twig_Extension[] $twigExtensions
     */
    private function addTwigExtensions(array $twigExtensions)
    {
        foreach ($twigExtensions as $extension) {
            $this->twigEnvironment->addExtension($extension);
        }
    }

    private function addTwigTemplatePath(TemplateNamespace $templateNamespace)
    {
        $this->twigLoader->addPath(
            $templateNamespace->getTemplatesPath(),
            $templateNamespace->getNamespace()
        );


    }
}
