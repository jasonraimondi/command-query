<?php
namespace Jmondi\Gut\DomainModel\OAuth;

use DateTime;
use Jmondi\Gut\DomainModel\Doctrine\StringEntityInterface;
use Jmondi\Gut\DomainModel\Entity\DateTime\CreatedAtTrait;
use Jmondi\Gut\DomainModel\Entity\Id\IdentifierTrait;

class OAuthRefreshToken implements StringEntityInterface
{
    use IdentifierTrait;
    use CreatedAtTrait;
    use ExpiresAndRevokableTrait;

    private const EXPIRES_AT_DATETIME_STRING = 'now + 1 month';

    /** @var string */
    private $identifier;
    /** @var DateTime */
    private $expiresAt;
    /** @var OAuthAccessToken */
    private $oAuthAccessToken;
    /** @var bool */
    private $isRevoked;

    public function __construct(
        ?string $identifier = null
    ) {
        $this->setCreatedAt();
        $this->setIdentifierToken($identifier);

        $this->isRevoked = false;
        $this->expiresAt = new DateTime(self::EXPIRES_AT_DATETIME_STRING);
    }

    public function jsonSerialize()
    {
        return [
            'identifier' => $this->identifier,
            'expiresAt' => $this->getExpiresAt()->getTimestamp(),
            'isExpired' => $this->isExpired(),
            'isRevoked' => $this->isRevoked(),
            'isValid' => $this->isValid(),
        ];
    }

    public function getId(): string
    {
        return $this->identifier;
    }

    public function getOAuthAccessToken(): OAuthAccessToken
    {
        return $this->oAuthAccessToken;
    }

    public function setOAuthAccessToken(OAuthAccessToken $oAuthAccessToken)
    {
        $this->oAuthAccessToken = $oAuthAccessToken;
    }
}
