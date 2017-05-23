<?php
namespace Jmondi\Gut\DomainModel\Entity\Error;

use JsonSerializable;

class ErrorCollection implements JsonSerializable
{
    /** @var array|ErrorDetail[] */
    private $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function jsonSerialize(): array
    {
        return [
            'errors' => $this->errors,
        ];
    }
}
