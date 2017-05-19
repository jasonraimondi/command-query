<?php
namespace Jmondi\Gut\Infrastructure\ApiClientLibrary;

use Jmondi\Gut\Infrastructure\Describer\ApiDescriber;
use Jmondi\Gut\Infrastructure\Template\SDKTemplateGenerator;
use Jmondi\Gut\Infrastructure\Template\Twig\TemplateNamespace;
use Jmondi\Gut\Infrastructure\Template\Twig\TwigTemplateGenerator;

class ApiClientLibraryGenerator
{
    /** @var string */
    private $clientLibraryTemplatePath;
    /** @var ApiDescriber */
    private $apiDescriber;

    public function __construct()
    {
        $this->clientLibraryTemplatePath = realpath(__DIR__ . '/../../../') . '/templates/api-client-libraries';
    }

    public function someting()
    {
        $typescriptClient = TypescriptClient::createNewClient();
        $typescriptClient->createActionFactory();
        $typescriptClient->createAllActions();
    }
}
