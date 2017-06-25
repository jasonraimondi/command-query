<?php
namespace Jmondi\Auth\Http\Controllers\OAuth;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Jmondi\Auth\Http\Controllers\Controller;
use Jmondi\Gut\DomainModel\Exception\EntityNotFoundException;
use Jmondi\Gut\DomainModel\User\User;
use Jmondi\Gut\Infrastructure\Repository\RepositoryFactory;
use Jmondi\Gut\Infrastructure\Service\ServiceFactory;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractLeagueOAuthController extends Controller
{
    /** @var ServiceFactory */
    protected $serviceFactory;
    /** @var RepositoryFactory */
    protected $repositoryFactory;
    /** @var null|AuthorizationServer */
    protected $authServer;

    public function __construct()
    {
        parent::__construct();
        $this->serviceFactory = $this->getApplicationCore()
            ->getServiceFactory();
        $this->repositoryFactory = $this->getApplicationCore()
            ->getRepositoryFactory();
    }

    public function revokeToken(Request $request)
    {
        try {
            $this->validate($request, [
                'token' => 'required',
                'userId' => 'required',
            ]);
        } catch (ValidationException $e) {
            return $this->createValidationErrorResponse($e);
        }

        $tokenRepository = $this->repositoryFactory
            ->getOAuthAccessTokenRepository();

        $token = $tokenRepository->getById($request->get('token'));
        $token->revoke();
        $tokenRepository->update($token);

        return $token->jsonSerialize();
    }

    /**
     * @param ServerRequestInterface $psrRequest
     * @param array|mixed $user
     * @return \Illuminate\Http\JsonResponse|\Psr\Http\Message\ResponseInterface
     */
    protected function authorizeServer(ServerRequestInterface $psrRequest, User $user)
    {
        try {
            $this->attemptAuthorization($psrRequest, $user);
        } catch (OAuthServerException $e) {
            return $this->jsonErrorMessage(
                $e->getHint() ?? $e->getMessage(),
                $e->getMessage(),
                501,
                $e
            );
        } catch (EntityNotFoundException $e) {
            return $this->jsonErrorMessage(
                $e->getFile() . ' line:' . $e->getLine(),
                $e->getMessage(),
                501,
                $e
            );
        } catch (\Throwable $e) {
            return $this->jsonErrorMessage(
                $e->getFile() . ' line:' . $e->getLine(),
                $e->getMessage(),
                501,
                $e
            );
        }
    }

    protected function getAuthorizationServer(): AuthorizationServer
    {
        if ($this->authServer === null) {
            $this->authServer = $this->serviceFactory
                ->getOAuthService()
                ->getAuthorizationServer();
        }

        return $this->authServer;
    }

    abstract public function attemptAuthorization(ServerRequestInterface $psrRequest, User $user);
}
