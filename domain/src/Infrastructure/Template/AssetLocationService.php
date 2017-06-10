<?php
namespace Jmondi\Gut\Infrastructure\Template;

class AssetLocationService
{
    public function getTemplateAssetFilepath(string $templateNamespace, string $path)
    {
        $templateNamespace = urldecode($templateNamespace);
        $path = urldecode($path);

        if ($templateNamespace[0] === '@') {
            $templateNamespace = $this->removeAtSymbol($templateNamespace);
        }

        $baseTemplatesPath = realpath(__DIR__ . '/../../../') . '/templates/';
        return $baseTemplatesPath . $templateNamespace . '/assets/' . $path;
    }

    private function removeAtSymbol(string $templateNamespace)
    {
        return substr($templateNamespace, 1);
    }
}
