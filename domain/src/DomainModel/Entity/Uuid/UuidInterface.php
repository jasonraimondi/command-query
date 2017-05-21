<?php
namespace Jmondi\Gut\DomainModel\Entity\Uuid;

interface UuidInterface
{
    public static function uuid4() : UuidInterface;
    public static function fromBytes(string $uuidBytes) : UuidInterface;
    public static function fromString(string $uuidString) : UuidInterface;
    public function toBytes() : string;
    public function getHex() : string;
    public function toString() : string;
}
