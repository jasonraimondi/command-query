<?php
namespace Jmondi\Gut\Entity\Type;

abstract class AbstractStringType extends AbstractType
{
    protected function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
