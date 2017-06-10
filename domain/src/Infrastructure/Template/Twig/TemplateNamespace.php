<?php
namespace Jmondi\Gut\Infrastructure\Template\Twig;

class TemplateNamespace
{
    /** @var string */
    private $templatesPath;
    /** @var string */
    private $namespace;

    private function __construct(string $templatesPath, string $namespace)
    {
        $this->templatesPath = $templatesPath;
        $this->namespace = $namespace;
    }

    public static function base()
    {
        $namespace = '_base';
        $templatesPath = realpath(__DIR__ . '/../../../../templates') . '/' . $namespace;
        return new self($templatesPath, $namespace);
    }

    public static function auth()
    {
        $namespace = 'auth';
        $templatesPath = realpath(__DIR__ . '/../../../../templates') . '/' . $namespace;
        return new self($templatesPath, $namespace);
    }

    public static function clientLibs()
    {
        $namespace = 'client-libs';
        $templatesPath = realpath(__DIR__ . '/../../../../templates') . '/' . $namespace;
        return new self($templatesPath, $namespace);
    }

    public function getTemplatesPath(): string
    {
        return $this->templatesPath;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }
}
