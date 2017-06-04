<?php
namespace Jmondi\Gut\DomainModel\User;

use Jmondi\Gut\DomainModel\Entity\Type\AbstractStringType;
use Jmondi\Gut\DomainModel\Entity\Type\TypeDetail;

class RoleType extends AbstractStringType
{
    protected const ADMIN = 'admin';

    /** @return TypeDetail[] */
    public static function getTypeDetails(): array
    {
        return [
            new TypeDetail(
                self::admin(),
                self::ADMIN,
                'Administrator'
            )
        ];
    }

    private static function admin()
    {
        return new static(static::ADMIN);
    }

    public function isAdmin()
    {
        return $this->is(self::ADMIN);
    }
}
