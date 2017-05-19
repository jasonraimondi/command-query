<?php
namespace Jmondi\Gut\Infrastructure\Describer;

class ApiDescriber
{
    /** @var string */
    protected $actionDirectoryPath;
    /** @var string */
    protected $entityDirectoryPath;
    /** @var string[] */
    protected $entityFiles;
    /** @var string */
    protected $srcDirectoryPath;

    /**
     * @return iterable|ApplicationReflectionClass[]
     */
    public function getAllEntityTypes()
    {
        $entityDirectoryPath = $this->getDirectoryPathStringRelativeSrc('DomainModel');
        $glotResults = glob($entityDirectoryPath . '/**/*Type.php');
        foreach($glotResults as $filePath) {
            if (! strpos($filePath, '/Abstract')) {
                yield new ApplicationReflectionClass($this->getNamespaceString($filePath, 'DomainModel'));
            }
        };
    }

    /**
     * @return iterable|ApplicationReflectionClass[]
     */
    public function getAllActionClasses(): iterable
    {
        $actionDirectoryPath = $this->getDirectoryPathStringRelativeSrc('Action');
        $globResults = glob($actionDirectoryPath . '/**/*.php');
        foreach($globResults as $filePath) {
            yield new ApplicationReflectionClass($this->getNamespaceString($filePath, 'Action'));
        };
    }

    private function getNamespaceString(string $filePath, string $needle): string
    {
        $class = 'Jmondi\\Gut\\' . strstr($filePath, $needle);
        $class = str_replace('.php', '', $class);
        return str_replace('/', '\\', $class);
    }

    private function getDirectoryPathStringRelativeSrc(string $needle): string
    {
        return realpath(__DIR__ . '/../../') . '/' . $needle;
    }
}
