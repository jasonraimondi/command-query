<?php
namespace Jmondi\Gut\Infrastructure\Template\Twig\Extension;

use Twig_Extension;
use Twig_SimpleFilter;

class TwigLowercaseFirstExtension extends Twig_Extension
{
    public function getName()
    {
        return 'lowercaseFirst';
    }

    public function getFilters()
    {
        return [
            new Twig_SimpleFilter(
                'lowercaseFirst',
                [$this, 'lowercaseFirstFilter'],
                ['is_safe' => ['html']]
            )
        ];
    }

    public function lowercaseFirstFilter($value)
    {
        return lcfirst($value);
    }
}
