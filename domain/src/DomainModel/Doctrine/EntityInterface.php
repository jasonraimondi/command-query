<?php
namespace Jmondi\Gut\DomainModel\Doctrine;

use Jmondi\Gut\Infrastructure\Lib\Query\ResponseInterface;

interface EntityInterface extends ResponseInterface
{
    public function getId();
}
