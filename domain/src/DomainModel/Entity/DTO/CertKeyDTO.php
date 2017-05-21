<?php
namespace Jmondi\Gut\DomainModel\Entity\DTO;

class CertKeyDTO
{
    /** @var resource */
    private $publicKey;
    /** @var resource */
    private $privateKey;

    public function __construct(
        string $privateKey,
        string $publicKey
    ) {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }
}
