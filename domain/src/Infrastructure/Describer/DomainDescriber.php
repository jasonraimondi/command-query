<?php
namespace Jmondi\Gut\Infrastructure\Describer;

use Jmondi\Gut\DomainModel\Entity\Type\AbstractType;
use Jmondi\Gut\Infrastructure\Lib\Command\CommandInterface;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryInterface;

class DomainDescriber
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
    public function getAllTypeReflectionClasses(): iterable
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
     * @return iterable|AbstractType[]
     */
    public function getAllAbstractTypes(): iterable
    {
        /** @var ApplicationReflectionClass $reflectionClass */
        foreach ($this->getAllTypeReflectionClasses() as $reflectionClass) {
            yield $reflectionClass->newInstanceWithoutConstructor();
        }
    }

    /**
     * @return iterable|ApplicationReflectionClass[]
     */
    public function getAllQueries(): iterable
    {
        $actionDirectoryPath = $this->getDirectoryPathStringRelativeSrc('Action');
        $globResults = glob($actionDirectoryPath . '/**/*.php');
        foreach($globResults as $filePath) {
            $reflectionClass = new ApplicationReflectionClass($this->getNamespaceString($filePath, 'Action'));
            if ($reflectionClass->newInstanceWithoutConstructor() instanceof QueryInterface) {
                yield $reflectionClass;
            }
        };
    }

    /**
     * @return iterable|ApplicationReflectionClass[]
     */
    public function getAllCommands(): iterable
    {
        $actionDirectoryPath = $this->getDirectoryPathStringRelativeSrc('Action');
        $globResults = glob($actionDirectoryPath . '/**/*.php');
        foreach($globResults as $filePath) {
            $reflectionClass = new ApplicationReflectionClass($this->getNamespaceString($filePath, 'Action'));
            if ($reflectionClass->newInstanceWithoutConstructor() instanceof CommandInterface) {
                yield $reflectionClass;
            }
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
