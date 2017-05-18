<?php
namespace Jmondi\Gut\Repository\User;

use Doctrine\ORM\EntityManager;
use Jmondi\Gut\Entity\User\User;

class DoctrineUserRepository implements UserRepositoryInterface
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getById(): User
    {
        // TODO: Implement getById() method.
    }
}
