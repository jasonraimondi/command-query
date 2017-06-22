<?php
namespace Jmondi\Gut\ActionHandler\OAuth;

use Jmondi\Gut\Action\OAuth\GetOAuthAccessToken;
use Jmondi\Gut\Infrastructure\Authorization\AuthorizationContextInterface;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryHandlerInterface;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthAccessTokenRepositoryInterface;

final class GetOAuthAccessTokenHandler implements QueryHandlerInterface
{
    /** @var GetOAuthAccessToken */
    private $query;
    /** @var OAuthAccessTokenRepositoryInterface */
    private $accessTokenRepository;

    public function __construct(
        GetOAuthAccessToken $query,
        OAuthAccessTokenRepositoryInterface $accessTokenRepository
    ) {
        $this->query = $query;
        $this->accessTokenRepository = $accessTokenRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAuthenticated();
    }

    public function execute()
    {
        return $this->accessTokenRepository->getById(
            $this->query->getOAuthAccessTokenId()
        );
    }
}
