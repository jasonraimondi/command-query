<?php
use Jmondi\Gut\Infrastructure\Template\Twig\TwigThemeConfig;

return new TwigThemeConfig(
    'tests',
    'Test',
    'A theme for running tests.',
    __DIR__,
    TwigThemeConfig::getThemePathFromNamespace('auth')
);
