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

    public static function createFromNamespace(string $namespace)
    {
        return new static(
            self::getBaseTemplatePath($namespace),
            $namespace
        );
    }

    public static function getBaseTemplatePath(string $namespace)
    {
        return realpath(__DIR__ . '/../../../../templates') . '/' . $namespace;
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
