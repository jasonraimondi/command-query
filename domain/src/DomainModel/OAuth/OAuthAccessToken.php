<?php
namespace Jmondi\Gut\DomainModel\OAuth;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Jmondi\Gut\DomainModel\Doctrine\StringEntityInterface;
use Jmondi\Gut\DomainModel\Entity\DateTime\CreatedAtTrait;
use Jmondi\Gut\DomainModel\Entity\Id\IdentifierTrait;
use Jmondi\Gut\DomainModel\User\User;

class OAuthAccessToken implements StringEntityInterface
{
    use IdentifierTrait;
    use CreatedAtTrait;
    use ExpiresAndRevokableTrait;

    private const EXPIRES_AT_DATETIME_STRING = 'now + 1 month';

    /** @var string */
    private $identifier;
    /** @var User */
    private $user;
    /** @var OAuthClient */
    private $oAuthClient;
    /** @var OAuthScope[] */
    private $oAuthScopes;

    public function __construct(
        User $user,
        OAuthClient $oAuthClient,
        ?string $identifier = null
    ) {
        $this->setIdentifierToken($identifier);
        $this->setCreatedAt();
        $this->oAuthScopes = new ArrayCollection();
        $this->isRevoked = false;
        $this->expiresAt = new DateTime(self::EXPIRES_AT_DATETIME_STRING);
        $this->user = $user;
        $this->oAuthClient = $oAuthClient;
    }

    public function getId(): string
    {
        return $this->identifier;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getOAuthClient()
    {
        return $this->oAuthClient;
    }

    public function setOAuthClient(OAuthClient $client)
    {
        $this->oAuthClient = $client;
    }

    public function addOAuthScope(OAuthScope $oAuthScope)
    {
        $this->oAuthScopes->add($oAuthScope);
    }

    public function getOAuthScopes()
    {
        return $this->oAuthScopes;
    }

    public function jsonSerialize()
    {
        return [
            'oAuthScopes' => $this->oAuthScopes,
            'expiresAt' => $this->getExpiresAt()->getTimestamp(),
            'isExpired' => $this->isExpired(),
            'isRevoked' => $this->isRevoked(),
            'isValid' => $this->isValid(),
        ];
    }
}
