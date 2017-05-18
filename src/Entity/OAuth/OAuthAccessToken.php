<?php

namespace Jmondi\Gut\Entity\OAuth;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Jmondi\Gut\Doctrine\EntityInterface;
use Jmondi\Gut\Doctrine\StringEntityInterface;
use Jmondi\Gut\Entity\DateTime\CreatedAtTrait;
use Jmondi\Gut\Entity\Id\IdentifierTrait;
use Jmondi\Gut\Entity\User\User;

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
    private $oauthClient;
    /** @var OAuthScope[] */
    private $oAuthScopes;

    public function __construct(
        User $user,
        OAuthClient $oauthClient,
        ?string $identifier = null
    ) {
        $this->setIdentifierToken($identifier);
        $this->setCreatedAt();
        $this->oAuthScopes = new ArrayCollection();
        $this->isRevoked = false;
        $this->expiresAt = new DateTime(self::EXPIRES_AT_DATETIME_STRING);
        $this->user = $user;
        $this->oauthClient = $oauthClient;
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
        return $this->oauthClient;
    }

    public function setOAuthClient(OAuthClient $client)
    {
        $this->oauthClient = $client;
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
