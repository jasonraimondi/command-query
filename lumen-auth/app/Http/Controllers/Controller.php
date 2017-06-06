<?php
namespace Jmondi\Auth\Http\Controllers;

use Jmondi\Gut\Infrastructure\Lib\ApplicationCore;
use Jmondi\Gut\Infrastructure\Template\AuthTemplateGenerator;
use Jmondi\Gut\Infrastructure\Template\Twig\TemplateNamespace;
use Jmondi\Gut\Infrastructure\Template\Twig\TwigTemplateGenerator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /** @var AuthTemplateGenerator */
    private $templateGenerator;

    public function __construct()
    {

        dd(true);
        $twigTemplateGenerator = TwigTemplateGenerator::createFromTemplateNamespace(
            new TemplateNamespace(
                realpath(__DIR__ . '/../../../..') . '/templates/base',
                'auth'
            )
        );

        $this->templateGenerator = new AuthTemplateGenerator($twigTemplateGenerator->getTwigEnvironment());
    }

    protected function renderView(string $page, array $parameters)
    {
        return $this->templateGenerator->renderView($page, $parameters);
    }

    protected function getApplicationCore(): ApplicationCore
    {
        return app(ApplicationCore::class);
    }
}

