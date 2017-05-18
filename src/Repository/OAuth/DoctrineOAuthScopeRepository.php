<?php
namespace Jmondi\Gut\Repository\OAuth;

use Doctrine\ORM\EntityManager;
use Jmondi\Gut\Entity\Uuid\Uuid;
use Jmondi\Gut\Entity\Exception\EntityNotFoundException;
use Jmondi\Gut\Entity\OAuth\OAuthScope;

class DoctrineOAuthScopeRepository implements OAuthScopeRepositoryInterface
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getById(string $oauthRefreshTokenId): OAuthScope
    {
        return $this->returnOrThrowNotFoundException(
            $this->getQueryBuilder()
                ->where('OAuthScope.id = :OAuthScopeId')
                ->setParameter('OAuthScopeId', Uuid::fromString($oauthRefreshTokenId)->toBytes())
                ->getQuery()
                ->getOneOrNullResult()
        );
    }

    public function create(OAuthScope & $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function update(OAuthScope & $entity): void
    {
        $this->assertManaged($entity);
        $this->entityManager->flush();
    }

    private function assertManaged(OAuthScope $entity)
    {
        if (! $this->entityManager->contains($entity)) {
            throw EntityNotFoundException::oauthScope();
        }
    }

    private function returnOrThrowNotFoundException(?OAuthScope $entity): OAuthScope
    {
        if ($entity === null) {
            throw EntityNotFoundException::oauthScope();
        }

        return $entity;
    }

    private function getQueryBuilder(): \Doctrine\ORM\QueryBuilder
    {
        return $this->entityManager->getRepository(OAuthScope::class)->createQueryBuilder('OAuthScope');
    }
}
