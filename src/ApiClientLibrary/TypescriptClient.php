<?php
namespace Jmondi\Gut\ApiClientLibrary;

use Jmondi\Gut\Template\Twig\TemplateNamespace;
use Jmondi\Gut\Template\Twig\TwigTemplateGenerator;

class TypescriptClient extends AbstractClientLibrary
{
    public static function createNewClient(): self
    {
        return new static('typescript', 'ts');
    }

    public function createActionFactory()
    {
        $this->render(
            'action-factory',
            [
                'actionClasses' => $something = iterator_to_array($this->apiDescriber->getAllActionClasses()),
            ],
            'Api/action-factory'
        );
    }

    public function createAllActions()
    {
        foreach ($this->apiDescriber->getAllActionClasses() as $action) {
            $this->render(
                'action-class',
                [
                    'action' => $action,
                ],
                'Api/Action/' . lcfirst($action->getActionDomain())
            );
        }
    }

    public function createAllTypes()
    {
        foreach ($this->apiDescriber->getAllEntityTypes() as $type) {
            $this->render(
                'type-class',
                [
                    'type' => $type,
                ],
                'Api/Type/' . lcfirst($type->getActionDomain())
            );
        }
    }
}
