<?php
namespace Jmondi\Gut\ActionHandler\OAuth;

use Jmondi\Gut\Action\OAuth\GetOAuthRefreshToken;
use Jmondi\Gut\Infrastructure\Authorization\AuthorizationContextInterface;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryHandlerInterface;
use Jmondi\Gut\Infrastructure\Repository\OAuth\OAuthRefreshTokenRepositoryInterface;

final class GetOAuthRefreshTokenHandler implements QueryHandlerInterface
{
    /** @var GetOAuthRefreshToken */
    private $query;
    /** @var OAuthRefreshTokenRepositoryInterface */
    private $refreshTokenRepository;

    public function __construct(
        GetOAuthRefreshToken $query,
        OAuthRefreshTokenRepositoryInterface $refreshTokenRepository
    ) {
        $this->query = $query;
        $this->refreshTokenRepository = $refreshTokenRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAuthenticated();
    }

    public function execute()
    {
        return $this->refreshTokenRepository->getById(
            $this->query->getOAuthRefreshTokenId()
        );
    }
}
