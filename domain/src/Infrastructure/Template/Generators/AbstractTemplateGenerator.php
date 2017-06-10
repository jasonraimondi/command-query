<?php
namespace Jmondi\Gut\Infrastructure\Template\Generators;

use Jmondi\Gut\Infrastructure\Template\Exceptions\TemplateGeneratorException;
use Jmondi\Gut\Infrastructure\Template\RouteUrlInterface;
use Jmondi\Gut\Infrastructure\Template\Twig\TemplateNamespace;
use Jmondi\Gut\Infrastructure\Template\Twig\TwigTemplateGenerator;
use Twig_Environment;
use Twig_Error_Loader;

abstract class AbstractTemplateGenerator
{
    /** @var TemplateNamespace */
    protected $templateNamespace;
    /** @var Twig_Environment */
    protected $twigEnvironment;

    public function __construct(TemplateNamespace $templateNamespace, RouteUrlInterface $routeUrl)
    {
        $this->templateNamespace = $templateNamespace;
        $this->twigEnvironment = TwigTemplateGenerator::createTemplateGenerator($routeUrl)->getTwigEnvironment();
    }

    public function renderView(string $templateName, array $parameters = []): string
    {
        $templateName = $this->getTemplateFile($templateName);

        try {
            $template = $this->twigEnvironment->load($templateName);
        } catch (Twig_Error_Loader $e) {
            throw TemplateGeneratorException::templateNotFound($e->getMessage());
        }

        return $template->render($parameters);
    }

    private function getTemplateFile(string $templateName): string
    {
        return '@' . $this->templateNamespace->getNamespace() . '/' . $templateName . '.twig';
    }
}
