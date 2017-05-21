<?php
namespace Jmondi\Gut\Infrastructure\Template;

interface MarkdownParserInterface
{
    public function render(string $string): string;
}
