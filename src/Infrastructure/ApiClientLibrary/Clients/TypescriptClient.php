<?php
namespace Jmondi\Gut\Infrastructure\ApiClientLibrary\Clients;

final class TypescriptClient extends AbstractClientLibrary
{
    public static function createNewClient(): self
    {
        return new static('typescript', 'ts');
    }

    public function renderFullSDK(): void
    {
        $this->createActionFactory();
        $this->createTypeFactory();
        $this->createAllActions();
        $this->createAllTypes();
    }

    private function createActionFactory()
    {
        $this->render(
            'action-factory',
            [
                'actionClasses' => $something = iterator_to_array($this->apiDescriber->getAllActionClasses()),
            ],
            'Api/action-factory'
        );
    }

    private function createTypeFactory()
    {
        $this->render(
            'type-factory',
            [
                'typeClasses' => $something = iterator_to_array($this->apiDescriber->getAllEntityTypes()),
            ],
            'Api/type-factory'
        );
    }

    private function createAllActions()
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

    private function createAllTypes()
    {
        foreach ($this->apiDescriber->getAllEntityTypes() as $type) {
            $this->render(
                'type-class',
                [
                    'type' => $type,
                ],
                'Api/Type/' . lcfirst($type->getTypeDomain())
            );
        }
    }
}
