<?php
namespace Jmondi\Gut\Infrastructure\Template\Twig;

use Twig_Environment;
use Twig_Extension;
use Twig_Loader_Filesystem;

class TwigTemplateGenerator
{
    /** @var Twig_Environment */
    private $twigEnvironment;
    /** @var Twig_Loader_Filesystem */
    private $twigLoader;
    /** @var array|TwigThemeConfig[] */
    private $twigThemeConfigs;

    /**
     * @param TwigThemeConfig[] $twigThemeConfigs
     * @param Twig_Extension[] $twigExtensions
     */
    public function __construct(array $twigThemeConfigs, array $twigExtensions)
    {
        $this->twigLoader = new Twig_Loader_Filesystem();
        $this->twigEnvironment = new Twig_Environment($this->twigLoader);
        $this->twigThemeConfigs = $twigThemeConfigs;
        $this->addTwigExtensions($twigExtensions);
        foreach ($twigThemeConfigs as $config) {
            $this->addTwigThemeConfigs($config);
        }
    }

    private function addTwigExtensions($twigExtensions)
    {
        $this->twigEnvironment->setExtensions($twigExtensions);
    }

    private function addTwigThemeConfigs(TwigThemeConfig $twigThemeConfig)
    {
        $this->twigLoader->setPaths(
            $twigThemeConfig->getTwigTemplatePaths(),
            $twigThemeConfig->getNamespace()
        );

        if ($twigThemeConfig->hasParentTheme()) {
            $this->twigLoader->setPaths(
                $twigThemeConfig->getParentTheme()->getTwigTemplatePaths(),
                $twigThemeConfig->getParentTheme()->getNamespace()
            );
        }
    }

    public function getTwigEnvironment()
    {
        return $this->twigEnvironment;
    }
}
