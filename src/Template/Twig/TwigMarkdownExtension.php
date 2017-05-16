<?php
namespace Jmondi\Gut\Template\Twig;

use Jmondi\Gut\Template\MarkdownParserInterface;

class TwigMarkdownExtension extends \Twig_Extension
{
    private $markdownParser;

    public function __construct(MarkdownParserInterface $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function getFilters(): array
    {
        $markdownFilter = new \Twig_SimpleFilter(
            'markdown',
            [$this, 'markdownRender'],
            ['is_safe' => ['html']]
        );

        return [
            'markdown' => $markdownFilter,
        ];
    }

    public function markdownRender(string $markdownString): string
    {
        return $this->markdownParser->render($markdownString);
    }

    public function getName(): string
    {
        return 'markdownRender';
    }
}
