<?php
namespace Jmondi\Gut\Doctrine;

interface StringEntityInterface extends EntityInterface
{
    public function getId(): string;
}
