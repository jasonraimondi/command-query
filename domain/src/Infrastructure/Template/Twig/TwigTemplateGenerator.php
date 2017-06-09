<?php
namespace Jmondi\Gut\Infrastructure\Template\Twig;

use Assetic\Extension\Twig\AsseticExtension;
use Assetic\Factory\AssetFactory;
use Jmondi\Gut\Infrastructure\Template\LeagueCommonMark\MarkdownParser;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleFunction;

class TwigTemplateGenerator
{
    /** @var Twig_Environment */
    private $twigEnvironment;
    /** @var Twig_Loader_Filesystem */
    private $twigLoader;

    public static function createTemplateGenerator()
    {
        return new self([
            TemplateNamespace::auth(),
            TemplateNamespace::clientLibs(),
        ]);
    }

    /**
     * @param TemplateNamespace[] $twigTemplateNamespaces
     */
    private function __construct(array $twigTemplateNamespaces)
    {
        $this->twigLoader = new Twig_Loader_Filesystem();

        foreach ($twigTemplateNamespaces as $templateNamespace) {
            $this->addTwigTemplatePath($templateNamespace);
        }

        $this->twigEnvironment = new Twig_Environment($this->twigLoader);

        $this->twigEnvironment->addExtension(
            new TwigMarkdownExtension(MarkdownParser::createFromNothing())
        );

        $this->twigEnvironment->addExtension(
            new TwigLowercaseFirstExtension()
        );

        new Twig_SimpleFunction(
            'assetUrl',
            function ($theme, $section, $path) {
                return $this->routeUrl->getRoute(
                    'asset.serve',
                    [
                        'theme' => $theme,
                        'section' => $section,
                        'path' => $path,
                    ]
                );
            }
        );
    }

    private function addTwigTemplatePath(TemplateNamespace $templateNamespace)
    {
        $this->twigLoader->addPath(
            $templateNamespace->getTemplatesPath(),
            $templateNamespace->getNamespace()
        );


    }

    public function getTwigEnvironment()
    {
        return $this->twigEnvironment;
    }
}
