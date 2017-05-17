<?php
namespace Jmondi\Gut\App\Uuid;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface as RamseyUuidInterface;

class Uuid implements UuidInterface
{
    /** @var RamseyUuidInterface */
    private $ramseyUuid;

    public function __construct(RamseyUuidInterface $ramseyUuid)
    {
        $this->ramseyUuid = $ramseyUuid;
    }

    public static function uuid4(): UuidInterface
    {
        return new self(RamseyUuid::uuid4());
    }

    public static function fromString(string $uuidString): UuidInterface
    {
        return new self(RamseyUuid::fromString($uuidString));
    }

    public static function fromBytes(string $uuidBytes): UuidInterface
    {
        return new self(RamseyUuid::fromBytes($uuidBytes));
    }

    public function toHex(): string
    {
        return $this->ramseyUuid->getHex();
    }

    public function toString(): string
    {
        return $this->ramseyUuid->toString();
    }

    public function toBytes(): string
    {
        return $this->ramseyUuid->getBytes();
    }
}
