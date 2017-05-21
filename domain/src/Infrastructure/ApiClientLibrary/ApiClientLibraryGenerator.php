<?php
namespace Jmondi\Gut\Infrastructure\ApiClientLibrary;

use Jmondi\Gut\Infrastructure\ApiClientLibrary\Clients\TypescriptClient;

class ApiClientLibraryGenerator
{
    public function execute()
    {
        $typescriptClient = TypescriptClient::createNewClient();
        $typescriptClient->renderFullSDK();
    }
}
