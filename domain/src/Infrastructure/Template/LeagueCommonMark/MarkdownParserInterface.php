<?php
namespace Jmondi\Gut\Infrastructure\Template\LeagueCommonMark;

interface MarkdownParserInterface
{
    public function render(string $string): string;
}
