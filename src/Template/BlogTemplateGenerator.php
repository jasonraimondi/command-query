<?php
namespace Jmondi\Gut\Template;

use Jmondi\Gut\Template\Exceptions\TemplateGeneratorException;
use Twig_Environment;
use Twig_Error_Loader;

class BlogTemplateGenerator
{
    /** @var Twig_Environment */
    private $twigEnvironment;

    public function __construct(Twig_Environment $twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    public function renderView(string $templateName, array $parameters = []): string
    {
        $templateName = $this->getTemplateFile($templateName);

        try {
            $template = $this->twigEnvironment->load($templateName);
        } catch (Twig_Error_Loader $e) {
            throw TemplateGeneratorException::templateNotFound($templateName);
        }

        return $template->render($parameters);
    }

    private function getTemplateFile(string $templateName): string
    {
        return '@site/' . $templateName . '.twig';
    }
}
