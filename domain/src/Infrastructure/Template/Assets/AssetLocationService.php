<?php
namespace Jmondi\Gut\Infrastructure\Template\Assets;

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
        return realpath(__DIR__ . '/../../../../../') . '/templates/' . $this->stripNamespaceAt($templateNamespace);
    }

    private function stripNamespaceAt(string $templateNamespace): string
    {
        if ($templateNamespace[0] === '@') {
            $templateNamespace = substr($templateNamespace, 1);
        }
        return $templateNamespace;
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
