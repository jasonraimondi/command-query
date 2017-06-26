<?php
namespace Jmondi\Auth\Http\Controllers\OAuth;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Jmondi\Gut\DomainModel\LeagueOAuth2Server\LeagueUserEntity;
use Jmondi\Gut\DomainModel\User\PasswordException;
use Jmondi\Gut\DomainModel\User\User;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;

class ImplicitController extends AbstractLeagueOAuthController
{
    public function index(Request $request)
    {
        try {
            $this->validate($request, [
                'response_type' => 'required',
                'client_id' => 'required',
                'redirect_uri' => 'required',
            ]);
        } catch (ValidationException $e) {
            return $this->createValidationErrorResponse($e);
        }

        return $this->renderView('@auth/pages/login', [
            'clientId' => $request->get('client_id'),
            'responseType' => $request->get('response_type'),
            'redirectUri' => $request->get('redirect_uri'),
        ]);
    }


    public function postImplicit(ServerRequestInterface $psrRequest, Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
                'response_type' => 'required',
                'client_id' => 'required',
                'redirect_uri' => 'required',
                'state' => '',
                'scope' => '',
            ]);
        } catch (ValidationException $e) {
            return $this->createValidationErrorResponse($e);
        }

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
        $authRequest = $this->getAuthorizationServer()->validateAuthorizationRequest($psrRequest);
        $authRequest->setUser(LeagueUserEntity::createFromUser($user));

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
