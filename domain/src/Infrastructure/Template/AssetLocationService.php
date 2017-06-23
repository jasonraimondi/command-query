<?php
namespace Jmondi\Gut\Infrastructure\Template;

use Jmondi\Gut\Infrastructure\Template\Exceptions\TemplateGeneratorException;

class AssetLocationService
{
    public function getTemplateAssetFilepath(string $templateNamespace, string $path)
    {
        $templateNamespace = urldecode($templateNamespace);
        $path = urldecode($path);
        return $this->getTemplateAssetsPath($this->stripNamespaceAt($templateNamespace)) . '/' . $path;
    }

    public function getTemplateAssetsPath(string $templateNamespace)
    {
        return $this->getTemplatesBasePath($this->stripNamespaceAt($templateNamespace)) . '/assets';
    }

    public function getTemplatesBasePath(string $templateNamespace): string
    {
        return realpath(__DIR__ . '/../../../') . '/templates/' . $this->stripNamespaceAt($templateNamespace);
    }

    private function stripNamespaceAt(string $templateNamespace): string
    {
        if ($templateNamespace[0] === '@') {
            $templateNamespace = $this->removeAtSymbol($templateNamespace);
        }
        return $templateNamespace;
    }

    private function removeAtSymbol(string $templateNamespace): string
    {
        return substr($templateNamespace, 1);
    }

    public function getTemplateManifest(string $templateNamespace): array
    {
        try {
            $manifestFilepath = $this->getTemplateAssetsPath($templateNamespace) . '/manifest.json';
            return json_decode(file_get_contents($manifestFilepath), true);
        } catch (\Throwable $e) {
            return [];
        }
    }
}
