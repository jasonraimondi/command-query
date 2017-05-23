<?php
namespace Jmondi\Gut\Test;

use Jmondi\Gut\DomainModel\Doctrine\UuidEntityInterface;

abstract class ApplicationTestCase extends \PHPUnit_Framework_TestCase
{
    protected function assertEntitiesEqual(UuidEntityInterface $entity1, UuidEntityInterface $entity2)
    {
        if (! $entity1->getId()->equals($entity2->getId())) {
            $this->fail(
                'Failed asserting entities ARE equal:' . PHP_EOL .
                get_class($entity1) . ': ' . $entity1->getId()->getHex() . PHP_EOL .
                get_class($entity2) . ': ' . $entity2->getId()->getHex()
            );
        }
    }

    protected function assertEntitiesNotEqual(UuidEntityInterface $entity1, UuidEntityInterface $entity2)
    {
        if ($entity1->getId()->equals($entity2->getId())) {
            $this->fail(
                'Failed asserting entities NOT equal:' . PHP_EOL .
                get_class($entity1) . ': ' . $entity1->getId()->getHex() . PHP_EOL .
                get_class($entity2) . ': ' . $entity2->getId()->getHex()
            );
        }
    }

    /**
     * @param UuidEntityInterface $expectedEntity
     * @param UuidEntityInterface[] $entities
     */
    protected function assertEntityInArray(UuidEntityInterface $expectedEntity, array $entities)
    {
        $this->assertTrue($this->isEntityInArray($expectedEntity, $entities));
    }

    /**
     * @param UuidEntityInterface $expectedEntity
     * @param UuidEntityInterface[] $entities
     * @return bool
     */
    protected function isEntityInArray(UuidEntityInterface $expectedEntity, array $entities)
    {
        foreach ($entities as $entity) {
            if ($expectedEntity->getId()->equals($entity->getId())) {
                return true;
            }
        }

        return false;
    }
}
