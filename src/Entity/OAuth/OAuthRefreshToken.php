<?php
namespace Jmondi\Gut\Entity\OAuth;

use DateTime;
use Jmondi\Gut\Doctrine\EntityInterface;
use Jmondi\Gut\Doctrine\StringEntityInterface;
use Jmondi\Gut\Entity\DateTime\CreatedAtTrait;
use Jmondi\Gut\Entity\Id\IdentifierTrait;

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
    private $oauthAccessToken;
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

    public function setOAuthAccessToken(OAuthAccessToken $oauthAccessToken)
    {
        $this->oauthAccessToken = $oauthAccessToken;
    }

    public function getOAuthAccessToken(): OAuthAccessToken
    {
        return $this->oauthAccessToken;
    }
}
