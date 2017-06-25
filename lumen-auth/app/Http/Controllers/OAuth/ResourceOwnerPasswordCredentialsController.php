<?php
namespace Jmondi\Auth\Http\Controllers\OAuth;

use Illuminate\Http\Request;
use Jmondi\Gut\DomainModel\LeagueOAuth2Server\LeagueUserEntity;
use Jmondi\Gut\DomainModel\User\PasswordException;
use Jmondi\Gut\DomainModel\User\User;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;

class ResourceOwnerPasswordCredentialsController extends AbstractLeagueOAuthController
{
    public function post(ServerRequestInterface $psrRequest, Request $request)
    {
        $this->validate($request, [
            'grant_type' => 'required',
            'client_id' => 'required',
            'client_secret' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'scope' => '',
        ]);

        $user = $this->repositoryFactory
            ->getUserRepository()
            ->getByEmail(
                $request->get('email')
            );

        if (!$user->isValidPassword($request->get('password'))) {
            throw PasswordException::invalidAccess();
        }

        return $this->authorizeServer($psrRequest, $user);
    }

    public function attemptAuthorization(ServerRequestInterface $psrRequest, User $user)
    {
        // Validate the HTTP request and return an AuthorizationRequest object.
        $authRequest = $this->getAuthorizationServer()->validateAuthorizationRequest($psrRequest);
        $authRequest->setUser(LeagueUserEntity::createFromUser($user)); // an instance of UserEntityInterface

        // At this point you should redirect the user to an authorization page.
        // This form will ask the user to approve the client and the scopes requested.
        // Once the user has approved or denied the client update the status
        // (true = approved, false = denied)
        $authRequest->setAuthorizationApproved(true);

        // Return the HTTP redirect response
        return $this->getAuthorizationServer()
            ->completeAuthorizationRequest(
                $authRequest,
                new Psr7Response()
            );
    }
}
