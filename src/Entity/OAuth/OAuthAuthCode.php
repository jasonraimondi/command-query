<?php
namespace Jmondi\Gut\Entity\OAuth;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Jmondi\Gut\Doctrine\EntityInterface;
use Jmondi\Gut\Doctrine\StringEntityInterface;
use Jmondi\Gut\Entity\DateTime\CreatedAtTrait;
use Jmondi\Gut\Entity\Id\IdentifierTrait;
use Jmondi\Gut\Entity\User\User;

class OAuthAuthCode implements StringEntityInterface
{
    use IdentifierTrait;
    use CreatedAtTrait;

    private const EXPIRES_AT_DATETIME_STRING = 'now + 1 month';

    /** @var User */
    private $user;
    /** @var OAuthClient */
    private $oauthClient;
    /** @var string */
    private $identifier;
    /** @var string[] */
    private $redirectUrls;
    /** @var OAuthScope[] */
    private $scopes;
    /** @var DateTime */
    private $expiresAt;

    public function __construct(
        User $user,
        OAuthClient $oauthClient,
        ?string $identifier = null
    ) {
        $this->setIdentifierToken($identifier);
        $this->scopes = new ArrayCollection();
        $this->redirectUrls = new ArrayCollection();
        $this->isRevoked = false;
        $this->expiresAt = new DateTime(self::EXPIRES_AT_DATETIME_STRING);
    }

    public function getId(): string
    {
        return $this->identifier;
    }

    public function jsonSerialize(): array
    {
        return [];
    }

    public function getRedirectUrl(): ArrayCollection
    {
        return $this->redirectUrls;
    }

    public function setRedirectUrl(string $redirectUrl)
    {
        $this->redirectUrls->add($redirectUrl);
    }

    public function getExpiresAt(): DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTime $expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getOAuthClient(): OAuthClient
    {
        return $this->oauthClient;
    }

    public function setOAuthClient(OAuthClient $client)
    {
        $this->oauthClient = $client;
    }

    public function addOAuthScope(OAuthScope $scope)
    {
        $this->scopes->add($scope);
    }

    /**
     * @return OAuthScope[]
     */
    public function getOAuthScopes(): array
    {
        return $this->scopes;
    }
}
