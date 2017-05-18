<?php
namespace Jmondi\Gut\Entity\OAuth;

use DateTime;

trait ExpiresAndRevokableTrait
{
    /** @var bool */
    private $isRevoked;
    /** @var DateTime */
    private $expiresAt;

    public function revoke()
    {
        $this->isRevoked = true;
    }

    public function isRevoked(): bool
    {
        return $this->isRevoked;
    }

    public function isValid(): bool
    {
        return $this->isRevoked() || $this->isExpired();
    }

    public function isExpired(): bool
    {
        return (new DateTime() > $this->expiresAt);
    }

    public function getExpiresAt(): DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTime $expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }
}