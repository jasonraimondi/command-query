<?php
namespace Jmondi\Gut\DomainModel\Entity\Json;

final class ApplicationJsonObject implements \JsonSerializable
{
    public function jsonSerialize()
    {
        return [];
    }
}
