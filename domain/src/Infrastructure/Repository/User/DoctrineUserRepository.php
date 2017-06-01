<?php
namespace Jmondi\Gut\Infrastructure\Repository\User;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Jmondi\Gut\DomainModel\Entity\Uuid\Uuid;
use Jmondi\Gut\DomainModel\Exception\EntityNotFoundException;
use Jmondi\Gut\DomainModel\User\User;

class DoctrineUserRepository implements UserRepositoryInterface
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getById(string $userId): User
    {
        return $this->returnOrThrowNotFoundException(
            $this->getQueryBuilder()
                ->where('User.id = :userId')
                ->setParameter('userId', Uuid::fromString($userId)->toBytes())
                ->getQuery()
                ->getOneOrNullResult()
        );
    }

    public function getByEmail(string $email): User
    {
        return $this->returnOrThrowNotFoundException(
            $this->getQueryBuilder()
                ->where('User.email = :email')
                ->setParameter('email', $email)
                ->getQuery()
                ->getOneOrNullResult()
        );
    }

    public function create(User & $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function update(User & $entity): void
    {
        $this->assertManaged($entity);
        $this->entityManager->flush();
    }

    private function assertManaged(User $entity)
    {
        if (! $this->entityManager->contains($entity)) {
            throw EntityNotFoundException::user();
        }
    }

    private function returnOrThrowNotFoundException(?User $entity): User
    {
        if ($entity === null) {
            throw EntityNotFoundException::user();
        }

        return $entity;
    }

    private function getQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(User::class)->createQueryBuilder('User');
    }
}
