<?php
namespace Jmondi\Gut\Test\ActionHandler\User;

use Jmondi\Gut\Action\User\GetUser;
use Jmondi\Gut\DomainModel\User\User;
use Jmondi\Gut\Test\TestCase\ActionTestCase;

class GetUserHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        User::class,
    ];

    public function testHandle()
    {
        $user = $this->addDummyUserToRepository();

        $query = $this->dispatchQuery(
            new GetUser($user->getId())
        );
        $this->entityManager->flush();
        $this->entityManager->clear();

        $sut = $this->getRepositoryFactory()
            ->getUserRepository()
            ->getById($user->getId());

        $this->assertEntitiesEqual($user, $sut);
    }
}
