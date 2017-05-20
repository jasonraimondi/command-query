<?php
namespace Jmondi\Gut\Infrastructure\ApiClientLibrary\Clients;

use Jmondi\Gut\Infrastructure\Describer\DomainDescriber;
use Jmondi\Gut\Infrastructure\Template\SDKTemplateGenerator;
use Jmondi\Gut\Infrastructure\Template\Twig\TemplateNamespace;
use Jmondi\Gut\Infrastructure\Template\Twig\TwigTemplateGenerator;

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
    /** @var DomainDescriber */
    protected $apiDescriber;
    /** @var SDKTemplateGenerator */
    protected $sdkTemplateGenerator;

    abstract public static function createNewClient();
    abstract public function renderFullSDK(): void;

    protected function __construct(string $clientLibraryName, string $extension)
    {
        $this->name = $clientLibraryName;
        $this->templatePath = realpath(__DIR__ . '/../../../../templates/api-client-libraries/' . $this->name . '/');
        $this->outputPath = realpath(__DIR__ . '/../../../../api-client-libraries/' . $this->name . '/');
        $this->extension = $extension;
        $this->apiDescriber = new DomainDescriber();
    }

    protected function render(string $templateName, array $parameters, string $outputFilePath, string $outputFileName): void
    {
        $twigContent = $this->getTemplateGenerator()->renderView(
            $this->name,
            $templateName,
            $parameters
        );

        $fullOutput = $this->outputPath . '/' . $outputFilePath;

        if (!file_exists($fullOutput)) {
            mkdir($fullOutput, 0775, true);
        }

        file_put_contents($fullOutput . '/' . $outputFileName . '.' . $this->extension, $twigContent);
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

    // https://secure.php.net/manual/en/function.get-class.php#114568
    protected function getBaseClassName(string $classname): string
    {
        if ($pos = strrpos($classname, '\\')) return substr($classname, $pos + 1);
        return $pos;
    }
}
