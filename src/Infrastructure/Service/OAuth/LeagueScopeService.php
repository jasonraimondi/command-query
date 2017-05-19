<?php
namespace Jmondi\Gut\Infrastructure\Service\OAuth;

use Jmondi\Gut\DomainModel\LeagueOAuth2Server\LeagueScopeEntity;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthScopeRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class LeagueScopeService implements ScopeRepositoryInterface
{
    /** @var OAuthScopeRepositoryInterface */
    private $scopeRepository;

    public function __construct(OAuthScopeRepositoryInterface $scopeRepository)
    {
        $this->scopeRepository = $scopeRepository;
    }

    /**
     * @param string $identifier The scope identifier
     * @return ScopeEntityInterface
     */
    public function getScopeEntityByIdentifier($identifier): ScopeEntityInterface
    {
        $scope = $this->scopeRepository->getById($identifier);
        return LeagueScopeEntity::createFromOAuthScope($scope);
    }

    /**
     * Given a client, grant type and optional user identifier validate the set of scopes requested are valid and optionally
     * append additional scopes or remove requested scopes.
     *
     * @param ScopeEntityInterface[] $scopes
     * @param string $grantType
     * @param ClientEntityInterface $clientEntity
     * @param null|string $userIdentifier
     *
     * @return ScopeEntityInterface[]
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ) {
        // @TODO
        return [];
    }
}
