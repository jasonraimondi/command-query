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


        $command = $this->dispatchQuery(
            new GetUser($user->getId())
        );

        $this->assertTrue(true);
    }
}
