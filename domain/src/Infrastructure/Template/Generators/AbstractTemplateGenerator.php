<?php
namespace Jmondi\Gut\Infrastructure\Template\Generators;

use Jmondi\Gut\Infrastructure\Template\Exceptions\TemplateGeneratorException;
use Jmondi\Gut\Infrastructure\Template\RouteUrlInterface;
use Jmondi\Gut\Infrastructure\Template\Twig\TwigTemplateGenerator;
use Twig_Environment;
use Twig_Error_Loader;

abstract class AbstractTemplateGenerator
{
    /** @var Twig_Environment */
    protected $twigEnvironment;

    public function __construct(RouteUrlInterface $routeUrl)
    {
        $this->twigEnvironment = TwigTemplateGenerator::createTemplateGenerator($routeUrl)->getTwigEnvironment();
    }

    public function renderView(string $templateNameWithNamespace, array $parameters = []): string
    {
        $templateNameWithNamespace = $templateNameWithNamespace . '.twig';

        try {
            $template = $this->twigEnvironment->load($templateNameWithNamespace);
            return $template->render($parameters);
        } catch (Twig_Error_Loader $e) {
            throw TemplateGeneratorException::templateNotFound($e->getMessage());
        }
    }
}
