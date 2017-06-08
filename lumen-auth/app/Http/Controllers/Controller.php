<?php
namespace Jmondi\Auth\Http\Controllers;

use Jmondi\Gut\Infrastructure\Lib\ApplicationCore;
use Jmondi\Gut\Infrastructure\Template\Generators\AuthTemplateGenerator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /** @var AuthTemplateGenerator */
    private $templateGenerator;

    public function __construct()
    {
        $this->templateGenerator = new AuthTemplateGenerator();
    }

    protected function renderView(string $page, array $parameters = [])
    {
        return $this->templateGenerator->renderView($page, $parameters);
    }

    protected function getApplicationCore(): ApplicationCore
    {
        return app(ApplicationCore::class);
    }
}

