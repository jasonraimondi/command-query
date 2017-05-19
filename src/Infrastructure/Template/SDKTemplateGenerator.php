<?php
namespace Jmondi\Gut\Infrastructure\Template;

use Jmondi\Gut\Infrastructure\Template\Exceptions\TemplateGeneratorException;
use Twig_Environment;
use Twig_Error_Loader;

class SDKTemplateGenerator
{
    /** @var Twig_Environment */
    private $twigEnvironment;

    public function __construct(Twig_Environment $twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    public function renderView(string $templateNamespace, string $templateName, array $parameters = []): string
    {
        $templateName = $this->getTemplateFile($templateNamespace, $templateName);

        try {
            $template = $this->twigEnvironment->load($templateName);
        } catch (Twig_Error_Loader $e) {
            throw TemplateGeneratorException::templateNotFound($e->getMessage());
        }

        return $template->render($parameters);
    }

    private function getTemplateFile(string $templateNamespace, string $templateName): string
    {
        return '@' . $templateNamespace . '/' . $templateName . '.twig';
    }
}
