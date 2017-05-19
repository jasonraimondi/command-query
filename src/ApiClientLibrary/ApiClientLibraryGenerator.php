<?php
namespace Jmondi\Gut\ApiClientLibrary;

use Jmondi\Gut\Describer\ApiDescriber;
use Jmondi\Gut\Template\SDKTemplateGenerator;
use Jmondi\Gut\Template\Twig\TemplateNamespace;
use Jmondi\Gut\Template\Twig\TwigTemplateGenerator;

class ApiClientLibraryGenerator
{
    /** @var string */
    private $clientLibraryTemplatePath;
    /** @var ApiDescriber */
    private $apiDescriber;

    public function __construct()
    {
        $this->clientLibraryTemplatePath = realpath(__DIR__ . '/../../') . '/templates/api-client-libraries';
    }

    public function someting()
    {
        $typescriptClient = TypescriptClient::createNewClient();
        $typescriptClient->createActionFactory();
        $typescriptClient->createAllActions();
    }
}
