<?php
namespace Jmondi\Gut\Test\TestCase;

use Jmondi\Gut\DomainModel\User\User;
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
}
