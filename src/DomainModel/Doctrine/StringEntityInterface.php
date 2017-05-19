<?php
namespace Jmondi\Gut\DomainModel\Doctrine;

interface StringEntityInterface extends EntityInterface
{
    public function getId(): string;
}
