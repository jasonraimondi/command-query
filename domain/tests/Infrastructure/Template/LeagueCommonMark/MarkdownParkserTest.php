<?php
namespace Jmondi\Gut\Test\Infrastructure\Template\LeagueCommonMark;

use Jmondi\Gut\Infrastructure\Template\LeagueCommonMark\MarkdownParser;
use Jmondi\Gut\Test\TestCase\ApplicationTestCase;

class MarkdownParserTest extends ApplicationTestCase
{
    /** @var MarkdownParser */
    private $markdownParser;

    public function setUp()
    {
        parent::setUp();
        $this->markdownParser = MarkdownParser::createFromNothing();
    }

    public function testBasicMarkdownConversionIsWorking()
    {
        $text = $this->markdownParser->render('This is **awesome**');
        $this->assertEquals('<p>This is <strong>awesome</strong></p>', rtrim($text));
    }

    public function testPHPCodeBlockClassesAreAdded()
    {
        $text = $this->markdownParser->render(file_get_contents(__DIR__ . '/templates/fake-codeblock-php.md'));
        $this->assertEquals('<pre><code class="language-php">$jason = true; ' . PHP_EOL . '</code></pre>', rtrim($text));
    }

    public function testJSCodeBlockClassesAreAdded()
    {
        $text = $this->markdownParser->render(file_get_contents(__DIR__ . '/templates/fake-codeblock-js.md'));
        $this->assertEquals('<pre><code class="language-javascript">let jason = true; ' . PHP_EOL . '</code></pre>', rtrim($text));
    }

    // @TODO Figure out how to make this test pass.
    public function xtestHeadersArePassedWithIds()
    {
        $text = $this->markdownParser->render('# This is Awesome');
        $this->assertEquals('<h1 id="this-is-awesome">This is Awesome</h1>', rtrim($text));
    }
}
