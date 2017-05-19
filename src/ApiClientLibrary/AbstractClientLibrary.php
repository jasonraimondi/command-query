<?php
namespace Jmondi\Gut\ApiClientLibrary;

use Jmondi\Gut\Describer\ApiDescriber;
use Jmondi\Gut\Template\SDKTemplateGenerator;
use Jmondi\Gut\Template\Twig\TemplateNamespace;
use Jmondi\Gut\Template\Twig\TwigTemplateGenerator;

abstract class AbstractClientLibrary
{
    /** @var string */
    protected $templatePath;
    /** @var string */
    protected $outputPath;
    /** @var string */
    protected $name;
    /** @var string */
    protected $extension;
    /** @var ApiDescriber */
    protected $apiDescriber;
    /** @var SDKTemplateGenerator */
    protected $sdkTemplateGenerator;

    abstract public static function createNewClient();

    protected function __construct(string $clientLibraryName, string $extension)
    {
        $this->name = $clientLibraryName;
        $this->templatePath = realpath(__DIR__ . '/../../templates/api-client-libraries/' . $this->name . '/');
        $this->outputPath = realpath(__DIR__ . '/../../api-client-libraries/' . $this->name . '/');
        $this->extension = $extension;
        $this->apiDescriber = new ApiDescriber();
    }

    public function render(string $templateName, array $parameters, string $outputFile): void
    {
        $twigContent = $this->getTemplateGenerator()->renderView(
            $this->name,
            $templateName,
            $parameters
        );

        file_put_contents($this->outputPath . '/' . $outputFile . '.' . $this->extension, $twigContent);
    }

    protected function getTemplateGenerator(): SDKTemplateGenerator
    {
        if ($this->sdkTemplateGenerator === null) {
            $twigTemplateGenerator = TwigTemplateGenerator::createFromTemplateNamespace(
                new TemplateNamespace(
                    $this->templatePath,
                    $this->name
                )
            );

            $this->sdkTemplateGenerator = new SDKTemplateGenerator(
                $twigTemplateGenerator->getTwigEnvironment()
            );
        }

        return $this->sdkTemplateGenerator;
    }
}
