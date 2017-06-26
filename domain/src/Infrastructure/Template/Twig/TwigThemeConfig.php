<?php
namespace Jmondi\Gut\Infrastructure\Template\Twig;

use Jmondi\Gut\DomainModel\Exception\NotFoundException;

class TwigThemeConfig
{
    /** @var string */
    private $namespace;
    /** @var string */
    private $name;
    /** @var string */
    private $description;
    /** @var string */
    private $themePath;
    /** @var null|TwigThemeConfig */
    private $parentTheme;
    /** @var string[] */
    private $twigTemplatePaths;

    public function __construct(
        string $namespace,
        string $name,
        string $description,
        string $themePath,
        ?string $parentThemePath = null
    ) {
        if (!file_exists($themePath)) {
            throw NotFoundException::themePathNotFound();
        }

        $this->name = $name;
        $this->description = $description;
        $this->themePath = $themePath;

        $this->addTwigTemplatePath($themePath . '/templates');

        if ($parentThemePath !== null) {
            $this->parentTheme = self::loadConfig($parentThemePath);
        }
        $this->namespace = $namespace;
    }

    public static function loadConfig(string $themePath): TwigThemeConfig
    {
        return include($themePath . '/config.php');
    }

    public static function loadConfigFromNamespace(string $namespace): TwigThemeConfig
    {
        $themePath = self::getThemePathFromNamespace($namespace);
        return include($themePath . '/config.php');
    }

    public static function getThemePathFromNamespace(string $namespace): string
    {
        return realpath(__DIR__ . '/../../../../../templates') . '/' . $namespace;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getTwigTemplatePaths(): array
    {
        $twigTemplatePaths = $this->twigTemplatePaths;

        if ($this->hasParentTheme()) {
            $twigTemplatePaths = array_merge($twigTemplatePaths, $this->parentTheme->getTwigTemplatePaths());
        }

        return $twigTemplatePaths;
    }

    private function addTwigTemplatePath(string $twigTemplatePath)
    {
        if (!file_exists($twigTemplatePath)) {
            throw NotFoundException::twigTemplatePathNotFound();
        }

        $this->twigTemplatePaths[] = $twigTemplatePath;
    }

    /**
     * @return bool
     */
    private function hasParentTheme()
    {
        return $this->parentTheme !== null;
    }
}
