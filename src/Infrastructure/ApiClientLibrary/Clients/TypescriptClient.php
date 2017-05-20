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
                'actionClasses' => $something = iterator_to_array($this->apiDescriber->getAllQueries()),
            ],
            'Api',
            'ActionFactory'
        );
    }

    private function createTypeFactory()
    {
        $this->render(
            'type-factory',
            [
                'typeClasses' => $something = iterator_to_array($this->apiDescriber->getAllTypeReflectionClasses()),
            ],
            'Api',
            'TypeFactory'
        );
    }

    private function createAllActions()
    {
        foreach ($this->apiDescriber->getAllQueries() as $action) {
            $this->render(
                'action-class',
                [
                    'action' => $action,
                ],
                'Api/Action',
                $action->getActionDomain() . 'Action'
            );
        }
    }

    private function createAllTypes()
    {
        foreach ($this->apiDescriber->getAllTypeReflectionClasses() as $type) {
            $this->render(
                'type-class',
                [
                    'type' => $type,
                    'typeDetails' => $type->newInstanceWithoutConstructor()::getTypeDetails(),
                ],
                'Api/Type',
                $type->getTypeDomain() . 'Type'
            );
        }
    }
}
