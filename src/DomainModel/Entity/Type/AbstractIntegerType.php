<?php
namespace Jmondi\Gut\DomainModel\Entity\Type;

abstract class AbstractIntegerType extends AbstractType
{
    protected function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
