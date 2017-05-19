<?php
namespace Jmondi\Gut\Infrastructure\Describer;

class ApplicationReflectionClass extends \ReflectionClass
{
    public function getActionDomain(): string
    {
        $pathFromActionDirectory = strstr($this->getName(), '\\Action');
        $pathFromActionDirectory = str_replace('\\Action\\', '', $pathFromActionDirectory);
        return str_replace('\\' . $this->getShortName(), '', $pathFromActionDirectory);
    }
}
