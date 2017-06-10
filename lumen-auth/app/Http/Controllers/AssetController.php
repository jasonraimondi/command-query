<?php
namespace Jmondi\Auth\Http\Controllers;

use Jmondi\Gut\Infrastructure\Template\AssetLocationService;

class AssetController extends Controller
{
    public function serve(string $templateNamespace, string $path)
    {
        $assetLocationService = $this->getAssetLocationService();
        $filePath = $assetLocationService->getTemplateAssetFilepath($templateNamespace, $path);
        $this->serveFile($filePath);
    }

    /**
     * @param string $filePath
     */
    protected function serveFile($filePath)
    {
        if (!file_exists($filePath)) {
            abort(404);
        }

        header('Content-Length: ' . filesize($filePath));
        header('Content-type: ' . $this->getMimeType($filePath));
        header('Expires: ' . date('r', strtotime('now +1 week')));
        header('Last-Modified: ' . date('r', filemtime($filePath)));
        header('Cache-Control: max-age=604800');
        ob_clean();
        flush();
        readfile($filePath);
        exit;
    }

    protected function getMimeType(string $file): string
    {
        $mime_types = [
            "pdf" => "application/pdf",
            "zip" => "application/zip",
            "docx" => "application/msword",
            "doc" => "application/msword",
            "xls" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "png" => "image/png",
            "jpeg" => "image/jpg",
            "jpg" => "image/jpg",
            "mp3" => "audio/mpeg",
            "wav" => "audio/x-wav",
            "mpeg" => "video/mpeg",
            "mpg" => "video/mpeg",
            "mpe" => "video/mpeg",
            "mov" => "video/quicktime",
            "avi" => "video/x-msvideo",
            "3gp" => "video/3gpp",
            "css" => "text/css",
            "jsc" => "application/javascript",
            "js" => "application/javascript",
            "php" => "text/html",
            "htm" => "text/html",
            "html" => "text/html",
        ];
        $variable = explode('.', $file);
        $extension = strtolower(end($variable));
        return $mime_types[$extension];
    }

    protected function getAssetLocationService()
    {
        $assetLocationService = new AssetLocationService();
        return $assetLocationService;
    }
}
