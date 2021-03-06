<?php
namespace Jmondi\Gut\Infrastructure\Template\Generators;

use Jmondi\Gut\Infrastructure\Template\Twig\TwigThemeConfig;
use Twig_Extension;

final class AuthTemplateGenerator extends AbstractTemplateGenerator
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
            TwigThemeConfig::loadConfigFromNamespace('auth'),
        ];
    }
}
