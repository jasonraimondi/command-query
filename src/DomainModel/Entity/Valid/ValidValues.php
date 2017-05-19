<?php
namespace Jmondi\Gut\DomainModel\Entity\Valid;

class ValidValues
{
    /** @var array */
    private $validValues;

    public function __construct(array $validValues)
    {
        $this->validValues = $validValues;
    }
}
