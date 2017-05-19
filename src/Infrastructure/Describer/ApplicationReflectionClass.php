<?php
namespace Jmondi\Gut\Infrastructure\Describer;

class ApplicationReflectionClass extends \ReflectionClass
{
    public function getActionDomain(): string
    {
        $path = strstr($this->getName(), '\\Action');
        $path = str_replace('\\Action\\', '', $path);
        return str_replace('\\' . $this->getShortName(), '', $path);
    }

    public function getTypeDomain(): string
    {
        $path = strstr($this->getName(), '\\DomainModel');
        $path = str_replace('\\DomainModel\\', '', $path);
        return str_replace('\\' . $this->getShortName(), '', $path);
    }
}
