<?php
namespace Jmondi\Gut\Test\ActionHandler\OAuth;

use Jmondi\Gut\Action\OAuth\GetOAuthAccessToken;
use Jmondi\Gut\DomainModel\OAuth\OAuthAccessToken;
use Jmondi\Gut\DomainModel\OAuth\OAuthClient;
use Jmondi\Gut\DomainModel\User\User;
use Jmondi\Gut\Test\TestCase\ActionTestCase;

class GetOAuthAccessTokenHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        User::class,
        OAuthClient::class,
        OAuthAccessToken::class,
    ];

    public function testHandle()
    {
        $user = $this->addDummyOAuthAccessTokenToRepository();

        $query = $this->dispatchQuery(
            new GetOAuthAccessToken($user->getId())
        );
        $this->entityManager->flush();
        $this->entityManager->clear();

        $sut = $this->getRepositoryFactory()
            ->getUserRepository()
            ->getById($user->getId());

        $this->assertEntitiesEqual($user, $sut);
    }
}
