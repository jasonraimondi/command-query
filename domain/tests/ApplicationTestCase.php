<?php
namespace Jmondi\Gut\Test;

use Jmondi\Gut\DomainModel\Doctrine\EntityInterface;

abstract class ApplicationTestCase extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    protected function assertEntitiesEqual(EntityInterface $entity1, EntityInterface $entity2)
    {
        if (! $entity1->getId() === $entity2->getId()) {
            $this->fail(
                'Failed asserting entities ARE equal:' . PHP_EOL .
                get_class($entity1) . ': ' . $entity1->getId() . PHP_EOL .
                get_class($entity2) . ': ' . $entity2->getId()
            );
        }
    }

    protected function assertEntitiesNotEqual(EntityInterface $entity1, EntityInterface $entity2)
    {
        if ($entity1->getId() === $entity2->getId()) {
            $this->fail(
                'Failed asserting entities NOT equal:' . PHP_EOL .
                get_class($entity1) . ': ' . $entity1->getId() . PHP_EOL .
                get_class($entity2) . ': ' . $entity2->getId()
            );
        }
    }

    /**
     * @param EntityInterface $expectedEntity
     * @param EntityInterface[] $entities
     */
    protected function assertEntityInArray(EntityInterface $expectedEntity, array $entities)
    {
        $this->assertTrue($this->isEntityInArray($expectedEntity, $entities));
    }

    /**
     * @param EntityInterface $expectedEntity
     * @param EntityInterface[] $entities
     * @return bool
     */
    protected function isEntityInArray(EntityInterface $expectedEntity, array $entities)
    {
        foreach ($entities as $entity) {
            if ($expectedEntity->getId() === $entity->getId()) {
                return true;
            }
        }

        return false;
    }
}
