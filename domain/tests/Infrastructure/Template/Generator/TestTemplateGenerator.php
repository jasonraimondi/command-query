<?php
namespace Jmondi\Gut\Test\Infrastructure\Template\Generator;

use Jmondi\Gut\Infrastructure\Template\Generators\AbstractTemplateGenerator;
use Jmondi\Gut\Infrastructure\Template\Twig\TwigThemeConfig;
use Twig_Extension;

class TestTemplateGenerator extends AbstractTemplateGenerator
{
    /**
     * @return Twig_Extension[]
     */
    protected function getExtensions(): array
    {
        return $this->getAllExtensions();
    }

    /**
     * @return TwigThemeConfig[]
     */
    protected function getThemeConfigs(): array
    {
        return [
            TwigThemeConfig::loadConfigFromNamespace('tests'),
        ];
    }
}
