<?php
namespace Jmondi\Gut\Infrastructure\Template\Twig\Extensions;

use Jmondi\Gut\Infrastructure\Template\LeagueCommonMark\MarkdownParserInterface;
use Twig_Extension;
use Twig_SimpleFilter;

class TwigMarkdownExtension extends Twig_Extension
{
    private $markdownParser;

    public function __construct(MarkdownParserInterface $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function getName(): string
    {
        return 'markdownRender';
    }

    public function getFilters(): array
    {
        return [
            new Twig_SimpleFilter(
                'markdown',
                [$this, 'markdownRender'],
                ['is_safe' => ['html']]
            )
        ];
    }

    public function markdownRender(string $markdownString): string
    {
        return $this->markdownParser->render($markdownString);
    }
}
