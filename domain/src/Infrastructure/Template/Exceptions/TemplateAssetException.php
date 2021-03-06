<?php
namespace Jmondi\Gut\Infrastructure\Template\Exceptions;

use Jmondi\Gut\DomainModel\Exception\ApplicationException;

class TemplateAssetException extends ApplicationException
{
    public static function namespaceTemplatePrefix()
    {
        return new self('Template namespaces must begin with @');
    }
}
