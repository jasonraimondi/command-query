<?php
namespace Jmondi\Gut\Infrastructure\ApiClientLibrary;

use Jmondi\Gut\Infrastructure\ApiClientLibrary\Clients\TypescriptClient;

class ApiClientLibraryGenerator
{
    /** @var string */
    private $clientLibraryTemplatePath;

    public function __construct()
    {
        $this->clientLibraryTemplatePath = realpath(__DIR__ . '/../../../') . '/templates/api-client-libraries';
    }

    public function execute()
    {
        $typescriptClient = TypescriptClient::createNewClient();
        $typescriptClient->createActionFactory();
        $typescriptClient->createAllActions();
    }
}
