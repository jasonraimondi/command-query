<?php
namespace Jmondi\Gut\Template;

use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\Extras\SmartPunct\SmartPunctExtension;
use League\CommonMark\HtmlRenderer;

class MarkdownParser implements MarkdownParserInterface
{
    /** @var Environment */
    private $environment;

    /** @var DocParser */
    private $parser;

    /** @var HtmlRenderer */
    private $renderer;

    public function __construct(Environment $environment, DocParser $parser, HtmlRenderer $renderer)
    {
        $this->environment = $environment;
        $this->parser = $parser;
        $this->renderer = $renderer;
    }

    public static function createFromNothing()
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new SmartPunctExtension());
        $environment->mergeConfig([
            'renderer' => [
                'block_separator' => "\n",
                'inner_separator' => "\n",
                'soft_break'      => "\n",
            ],
            'enable_em' => true,
            'enable_strong' => true,
            'use_asterisk' => true,
            'use_underscore' => true,
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
        ]);
        return new self(
            $environment,
            new DocParser($environment),
            new HtmlRenderer($environment)
        );
    }

    public function render(string $string): string
    {
        $document = $this->parser->parse($string);
        return $this->renderer->renderBlock($document);
    }
}
