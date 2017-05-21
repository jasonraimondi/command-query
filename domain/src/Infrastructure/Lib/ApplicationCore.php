<?php
namespace Jmondi\Gut\Infrastructure\Lib;

final class ApplicationCore
{
    /** @var array */
    private $doctrineDbParams;

    public function __construct(array $doctrineDbParams)
    {
        $this->doctrineDbParams = $doctrineDbParams;
    }
}
