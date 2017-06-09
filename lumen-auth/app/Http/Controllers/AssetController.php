<?php
namespace Jmondi\Auth\Http\Controllers;

class AssetController extends Controller
{
    public function serve($theme, $section, $path)
    {
        $assetLocationService = $this->getAssetLocationService();
        $filePath = $assetLocationService->getAssetFilePathByTheme($theme, $section, $path);
        $this->serveFile($filePath);
    }

    protected function getAssetLocationService()
    {
        $assetLocationService = new AssetLocationService();
        return $assetLocationService;
    }
}
