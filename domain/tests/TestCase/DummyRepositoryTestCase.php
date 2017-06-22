<?php
namespace Jmondi\Gut\Test\TestCase;

use Jmondi\Gut\DomainModel\OAuth\OAuthAccessToken;
use Jmondi\Gut\DomainModel\OAuth\OAuthClient;
use Jmondi\Gut\DomainModel\OAuth\OAuthRefreshToken;
use Jmondi\Gut\DomainModel\User\User;
use Jmondi\Gut\Test\Helper\DummyGenerator\OAuthAccessTokenGenerator;
use Jmondi\Gut\Test\Helper\DummyGenerator\OAuthClientGenerator;
use Jmondi\Gut\Test\Helper\DummyGenerator\OAuthRefreshTokenGenerator;
use Jmondi\Gut\Test\Helper\DummyGenerator\UserGenerator;

class DummyRepositoryTestCase extends RepositoryTestCase
{
    protected function addDummyUserToRepository(): User
    {
        $user = UserGenerator::createDummy();

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    protected function addDummyOAuthAccessTokenToRepository(
        ?User $user = null,
        ?OAuthClient $oAuthClient = null
    ): OAuthAccessToken {
        if ($user === null) {
            $user = $this->addDummyUserToRepository();
        }

        if ($oAuthClient === null) {
            $oAuthClient = $this->addDummyOAuthClientToRepository();
        }

        $oAuthAccessToken = OAuthAccessTokenGenerator::createDummy($user, $oAuthClient);

        $this->entityManager->persist($oAuthAccessToken);
        $this->entityManager->flush();

        return $oAuthAccessToken;
    }

    protected function addDummyOAuthRefreshTokenToRepository(
        ?User $user = null,
        ?OAuthClient $oAuthClient = null
    ): OAuthRefreshToken {
        if ($user === null) {
            $user = $this->addDummyUserToRepository();
        }

        if ($oAuthClient === null) {
            $oAuthClient = $this->addDummyOAuthClientToRepository();
        }

        $oAuthRefreshToken = OAuthRefreshTokenGenerator::createDummy($user, $oAuthClient);

        $this->entityManager->persist($oAuthRefreshToken);
        $this->entityManager->flush();

        return $oAuthRefreshToken;
    }

    protected function addDummyOAuthClientToRepository(): OAuthClient
    {
        $oAuthClient = OAuthClientGenerator::createDummy();

        $this->entityManager->persist($oAuthClient);
        $this->entityManager->flush();

        return $oAuthClient;
    }
}
