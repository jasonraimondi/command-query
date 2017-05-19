<?php
namespace Jmondi\Gut\DomainModel\OAuth;

use Doctrine\Common\Collections\ArrayCollection;
use Jmondi\Gut\DomainModel\Doctrine\StringEntityInterface;
use Jmondi\Gut\DomainModel\Entity\DateTime\CreatedAtTrait;
use Jmondi\Gut\DomainModel\Entity\Id\IdentifierTrait;

class OAuthClient implements StringEntityInterface
{
    use IdentifierTrait;
    use CreatedAtTrait;

    /** @var string */
    private $identifier;
    /** @var string */
    private $name;
    /** @var string[] */
    private $redirectUrls;
    /** @var OAuthAccessToken[] */
    private $oauthAccessTokens;

    public function __construct(
        string $name,
        ?string $identifier = null
    ) {
        $this->setCreatedAt();
        $this->setIdentifierToken($identifier);
        $this->name = $name;
        $this->oauthAccessTokens = new ArrayCollection();
        $this->redirectUrls = new ArrayCollection();
    }

    public function addOAuthAccessToken(OAuthAccessToken $accessToken)
    {
        $this->oauthAccessTokens->add($accessToken);
    }

    public function jsonSerialize()
    {
        return [
            'identifier' => $this->identifier,
            'name' => $this->name,
            'redirectUrls' => $this->redirectUrls
        ];
    }

    public function getId(): string
    {
        return $this->identifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getRedirectUrls()
    {
        return $this->redirectUrls;
    }
}
