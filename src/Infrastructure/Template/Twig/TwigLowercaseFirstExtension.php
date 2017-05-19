<?php

namespace Jmondi\Gut\Infrastructure\Template\Twig;

use Twig_Extension;

class TwigLowercaseFirstExtension extends Twig_Extension
{
    public function getFilters()
    {
        $lowercaseFirstFilter = new \Twig_SimpleFilter(
            'lowercaseFirst',
            [$this, 'lowercaseFirstFilter'],
            ['is_safe' => ['html']]
        );

        return [
            'lowercaseFirst' => $lowercaseFirstFilter
        ];
    }

    public function lowercaseFirstFilter($value)
    {
        return lcfirst($value);
    }

    public function getName()
    {
        return 'lowercaseFirst';
    }
}