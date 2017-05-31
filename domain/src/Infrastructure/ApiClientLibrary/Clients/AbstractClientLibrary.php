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

    protected function __construct(string $extension, string $clientLibraryName, string $pathInClientLibrary = '')
    {
        $projectRootDir = realpath(__DIR__ . '/../../../../');

        $this->name = $clientLibraryName;
        $this->templatePath = $projectRootDir . '/api-client-libraries/_templates/' . $this->name;
        $this->outputPath = $projectRootDir . 'api-client-libraries/' . $this->name . '/' . $pathInClientLibrary . '/';
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
    // we are just grabbing the class name without the full namespace
    protected function getBaseClassName(string $className): string
    {
        if ($pos = strrpos($className, '\\')) return substr($className, $pos + 1);
        return $pos;
    }
}
