<?php
namespace Jmondi\Gut\Template;

interface MarkdownParserInterface
{
    public function render(string $string): string;
}
