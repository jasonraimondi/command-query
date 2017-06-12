<?php
namespace Jmondi\Gut\Test\ActionHandler\User;

use Jmondi\Gut\Action\User\GetUser;
use Jmondi\Gut\DomainModel\User\User;
use Jmondi\Gut\Test\TestCase\ActionTestCase;

class GetUserHandler extends ActionTestCase
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

        var_dump($command);

        $this->assertTrue(true);
    }
}
