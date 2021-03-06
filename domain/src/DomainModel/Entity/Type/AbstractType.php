<?php
namespace Jmondi\Gut\DomainModel\Entity\Type;

use Jmondi\Gut\DomainModel\Exception\InvalidArgumentException;

abstract class AbstractType implements \JsonSerializable
{

    protected $id;

    /** @return TypeDetail[] */
    abstract public static function getTypeDetails(): array;
    abstract public function getId();

    public function getTypeDetail(): TypeDetail
    {
        foreach (static::getTypeDetails() as $typeDetail) {
            if ($typeDetail->getId() === $this->id) {
                return $typeDetail;
            }
        }

        throw InvalidArgumentException::invalidTypeId();
    }

    protected function is($value): bool
    {
        return $this->id === $value;
    }
//
    public function jsonSerialize()
    {
        return $this->getTypeDetail()->jsonSerialize();
    }
}
