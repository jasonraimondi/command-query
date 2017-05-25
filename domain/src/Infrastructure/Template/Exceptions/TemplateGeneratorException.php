<?php
namespace Jmondi\Gut\Infrastructure\Template\Exceptions;

use Exception;

class TemplateGeneratorException extends Exception
{
    public static function templateNotFound(string $templateName): self
    {
        return new self('Template not found: ' . $templateName);
    }
}