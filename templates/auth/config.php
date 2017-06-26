<?php
use Jmondi\Gut\Infrastructure\Template\Twig\TwigThemeConfig;

return new TwigThemeConfig(
    'auth',
    'Authentication',
    'A theme for running tests.',
    __DIR__,
    TwigThemeConfig::getThemePathFromNamespace('_base')
);
