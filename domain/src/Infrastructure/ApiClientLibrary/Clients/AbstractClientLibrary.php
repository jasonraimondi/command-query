<?php
namespace Jmondi\Gut\Infrastructure\ApiClientLibrary\Clients;

use Jmondi\Gut\Infrastructure\Describer\DomainDescriber;
use Jmondi\Gut\Infrastructure\Template\Generators\ClientLibTemplateGenerator;
use Jmondi\Gut\Infrastructure\Template\Twig\TemplateNamespace;
use Jmondi\Gut\Infrastructure\Template\Twig\TwigTemplateGenerator;

abstract class AbstractClientLibrary
{
    /** @var string */
    protected $outputPath;
    /** @var string */
    protected $name;
    /** @var string */
    protected $extension;
    /** @var DomainDescriber */
    protected $apiDescriber;
    /** @var ClientLibTemplateGenerator */
    protected $sdkTemplateGenerator;

    abstract public static function createNewClient();
    abstract public function renderFullSDK(): void;

    protected function __construct(string $extension, string $clientLibraryName, string $pathInClientLibrary = '')
    {
        $this->name = $clientLibraryName;
        $this->outputPath = realpath(__DIR__ . '/../../../../../') . '/api-client-libraries/' . $this->name . '/' . $pathInClientLibrary . '/';
        $this->extension = $extension;
        $this->apiDescriber = new DomainDescriber();
    }

    protected function render(string $templateName, array $parameters, string $outputFilePath, string $outputFileName): void
    {
        $twigContent = $this->getTemplateGenerator()->renderView(
            $templateName,
            $parameters
        );

        $fullPath = $this->outputPath . $outputFilePath;
        $fullOutputFileWithPath = $fullPath . '/' . $outputFileName . '.' . $this->extension;

        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0775, true);
        }

        file_put_contents($fullOutputFileWithPath, $twigContent);
    }

    protected function getTemplateGenerator(): ClientLibTemplateGenerator
    {
        return new ClientLibTemplateGenerator($this->name);
    }

    // https://secure.php.net/manual/en/function.get-class.php#114568
    // we are just grabbing the class name without the full namespace
    protected function getBaseClassName(string $className): string
    {
        if ($pos = strrpos($className, '\\')) {
            return substr($className, $pos + 1);
        }

        return $pos;
    }
}
