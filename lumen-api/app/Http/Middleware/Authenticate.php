<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Jmondi\Gut\DomainModel\Entity\Error\ErrorDetail;
use Jmondi\Gut\DomainModel\Entity\Error\ErrorCollection;
use Jmondi\Gut\DomainModel\Exception\ApplicationException;
use Jmondi\Gut\DomainModel\Exception\EntityNotFoundException;
use Jmondi\Gut\DomainModel\OAuth\OAuthAccessTokenException;
use Jmondi\Gut\Infrastructure\Lib\ApplicationCore;

class Authenticate
{
    /** @var ApplicationCore */
    private $applicationCore;

    public function __construct(ApplicationCore $applicationCore)
    {
        $this->applicationCore = $applicationCore;
    }

    /**
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $oAuthAccessTokenId = $this->getOAuthAccessTokenId($request);
            $this->applicationCore->setOauthAccessToken($oAuthAccessTokenId);
        } catch (OAuthAccessTokenException $e) {
            return response()->json(
                new ErrorCollection([
                    new ErrorDetail('Unauthorized Bearer Token', 'Unauthorized Access')
                ]),
                401
            );
        } catch (ApplicationException | EntityNotFoundException $e) {
            return response()->json(
                new ErrorCollection([
                    new ErrorDetail($e->getMessage(), 'Unauthorized Access')
                ]),
                401
            );
        } catch (\Throwable $e) {
            return response()->json(
                new ErrorCollection([
                    new ErrorDetail($e->getMessage(), 'Unauthorized Access')
                ]),
                401
            );
        }

        return $next($request);
    }

    private function getOauthAccessTokenId(Request $request): string
    {
        $authorizationString = $request->header('authorization');
        $oauthAccessTokenId = str_replace('Bearer ', '', $authorizationString);
        return $oauthAccessTokenId;
    }
}