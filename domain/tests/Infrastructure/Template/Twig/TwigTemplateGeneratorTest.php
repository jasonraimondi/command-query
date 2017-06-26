<?php
namespace Jmondi\Gut\Test\Infrastructure\Template\Twig;

use Jmondi\Gut\Infrastructure\Template\Assets\BlankRouteUrlGenerator;
use Jmondi\Gut\Infrastructure\Template\Exceptions\TemplateGeneratorException;
use Jmondi\Gut\Test\Infrastructure\Template\Generator\TestTemplateGenerator;
use Jmondi\Gut\Test\TestCase\RepositoryTestCase;

class TwigTemplateGeneratorTest extends RepositoryTestCase
{
    /** @var TestTemplateGenerator */
    private $testTemplateGenerator;

    public function setUp()
    {
        parent::setUp();
        $this->testTemplateGenerator = new TestTemplateGenerator(
            new BlankRouteUrlGenerator()
        );
    }

    public function testEmailIsGeneratedSuccessfully()
    {
        $htmlMessage = $this->testTemplateGenerator->renderView('@tests/fake-template', [
            'key' => 'value'
        ]);

        // the template files must not have a trailing space for the tests to pass.
        $this->assertSame("<p>This value</p>", rtrim($htmlMessage));
    }

    public function testExceptionsAreThrownForNotFoundTemplates()
    {
        $this->expectException(TemplateGeneratorException::class);
        $this->testTemplateGenerator->renderView('@tests/fake-template-nonexistant');
    }
}
