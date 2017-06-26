<?php
namespace Jmondi\Gut\Infrastructure\Template\Generators;

use Jmondi\Gut\Infrastructure\Template\Assets\RouteUrlInterface;
use Jmondi\Gut\Infrastructure\Template\Exceptions\TemplateGeneratorException;
use Jmondi\Gut\Infrastructure\Template\LeagueCommonMark\MarkdownParser;
use Jmondi\Gut\Infrastructure\Template\Twig\Extensions\TwigAssetManifestUrlExtension;
use Jmondi\Gut\Infrastructure\Template\Twig\Extensions\TwigAssetUrlExtension;
use Jmondi\Gut\Infrastructure\Template\Twig\Extensions\TwigMarkdownExtension;
use Jmondi\Gut\Infrastructure\Template\Twig\Extensions\TwigRouteUrlExtension;
use Jmondi\Gut\Infrastructure\Template\Twig\TwigTemplateGenerator;
use Jmondi\Gut\Infrastructure\Template\Twig\TwigThemeConfig;
use Twig_Environment;
use Twig_Error_Loader;
use Twig_Extension;

abstract class AbstractTemplateGenerator
{
    /** @var Twig_Environment */
    protected $twigEnvironment;
    /** @var RouteUrlInterface */
    protected $routeUrl;

    public function __construct(RouteUrlInterface $routeUrl)
    {
        $this->routeUrl = $routeUrl;
        $twigTemplateGenerator = new TwigTemplateGenerator(
            $this->getThemeConfigs(),
            $this->getExtensions(),
            $routeUrl
        );
        $this->twigEnvironment = $twigTemplateGenerator->getTwigEnvironment();
    }

    public function renderView(string $templateNameWithNamespace, array $parameters = []): string
    {
        $templateNameWithNamespace = $templateNameWithNamespace . '.twig';

        try {
            $template = $this->twigEnvironment->load($templateNameWithNamespace);
            return $template->render($parameters);
        } catch (Twig_Error_Loader $e) {
            throw TemplateGeneratorException::templateNotFound($e->getMessage());
        }
    }

    protected function getAllExtensions(): array
    {
        return [
            new TwigMarkdownExtension(MarkdownParser::createFromNothing()),
            new TwigAssetUrlExtension($this->routeUrl),
            new TwigAssetManifestUrlExtension($this->routeUrl),
            new TwigRouteUrlExtension($this->routeUrl),
        ];
    }

    /**
     * @return Twig_Extension[]
     */
    abstract protected function getExtensions(): array;

    /**
     * @return TwigThemeConfig[]
     */
    abstract protected function getThemeConfigs(): array;
}
