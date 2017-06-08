<?php
namespace Jmondi\Gut\Infrastructure\Template\Generators;

use Jmondi\Gut\Infrastructure\Template\Twig\TemplateNamespace;

final class ClientLibTemplateGenerator extends AbstractTemplateGenerator
{
    public function __construct(string $clientLibrary)
    {
        parent::__construct(TemplateNamespace::clientLibs());
    }
}
