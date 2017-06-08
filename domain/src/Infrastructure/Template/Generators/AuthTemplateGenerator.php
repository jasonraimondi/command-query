<?php
namespace Jmondi\Gut\Infrastructure\Template\Generators;

use Jmondi\Gut\Infrastructure\Template\Twig\TemplateNamespace;

final class AuthTemplateGenerator extends AbstractTemplateGenerator
{
    public function __construct()
    {
        parent::__construct(TemplateNamespace::auth());
    }
}
