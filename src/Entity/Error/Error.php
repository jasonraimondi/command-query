<?php
namespace Jmondi\Gut\Entity\Error;

class Error implements \JsonSerializable
{
    /** @var string */
    private $detail;
    /** @var null|string */
    private $title;
    /** @var null|int */
    private $statusCode;

    public function __construct(string $detail, ?string $title = null, ?int $statusCode = null)
    {
        $this->detail = $detail;
        $this->title = $title;
        $this->statusCode = $statusCode;
    }

    public function jsonSerialize()
    {
        return [
            'detail' => $this->detail,
            'title' => $this->title,
            'statusCode' => $this->statusCode,
        ];
    }
}
