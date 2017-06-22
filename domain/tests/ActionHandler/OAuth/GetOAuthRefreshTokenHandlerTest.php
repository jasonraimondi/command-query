<?php
namespace Jmondi\Gut\Test\ActionHandler\OAuth;

use Jmondi\Gut\Action\OAuth\GetOAuthRefreshToken;
use Jmondi\Gut\DomainModel\OAuth\OAuthAccessToken;
use Jmondi\Gut\DomainModel\OAuth\OAuthClient;
use Jmondi\Gut\DomainModel\OAuth\OAuthRefreshToken;
use Jmondi\Gut\DomainModel\User\User;
use Jmondi\Gut\Test\TestCase\ActionTestCase;

class GetOAuthRefreshTokenHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        User::class,
        OAuthClient::class,
        OAuthAccessToken::class,
        OAuthRefreshToken::class,
    ];

    public function testHandle()
    {
        $oAuthRefreshToken = $this->addDummyOAuthRefreshTokenToRepository();

        $query = $this->dispatchQuery(
            new GetOAuthRefreshToken($oAuthRefreshToken->getId())
        );
        $this->entityManager->flush();
        $this->entityManager->clear();

        $sut = $this->getRepositoryFactory()
            ->getOAuthRefreshTokenRepository()
            ->getById($oAuthRefreshToken->getId());

        $this->assertEntitiesEqual($oAuthRefreshToken, $sut);
    }
}
