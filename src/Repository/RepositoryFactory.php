<?php
namespace Jmondi\Gut\Service;

use Doctrine\ORM\EntityManager;
use Jmondi\Gut\Repository\User\DoctrineUserRepository;
use Jmondi\Gut\Repository\User\UserRepositoryInterface;

class RepositoryFactory
{
    /** @var EntityManager */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getUserRepository(): UserRepositoryInterface
    {
        return new DoctrineUserRepository($this->entityManager);
    }
}
