<?php
namespace Jmondi\Gut\Infrastructure\Repository\OAuth;

use Doctrine\ORM\EntityManager;
use Jmondi\Gut\DomainModel\Entity\Uuid\Uuid;
use Jmondi\Gut\DomainModel\Exception\EntityNotFoundException;
use Jmondi\Gut\DomainModel\OAuth\OAuthRefreshToken;

class DoctrineOAuthRefreshTokenRepository implements OAuthRefreshTokenRepositoryInterface
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getById(string $oauthRefreshTokenId): OAuthRefreshToken
    {
        return $this->returnOrThrowNotFoundException(
            $this->getQueryBuilder()
                ->where('OAuthRefreshToken.id = :OAuthRefreshTokenId')
                ->setParameter('OAuthRefreshTokenId', Uuid::fromString($oauthRefreshTokenId)->toBytes())
                ->getQuery()
                ->getOneOrNullResult()
        );
    }

    public function create(OAuthRefreshToken & $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function update(OAuthRefreshToken & $entity): void
    {
        $this->assertManaged($entity);
        $this->entityManager->flush();
    }

    private function assertManaged(OAuthRefreshToken $entity)
    {
        if (! $this->entityManager->contains($entity)) {
            throw EntityNotFoundException::oauthRefreshToken();
        }
    }

    private function returnOrThrowNotFoundException(?OAuthRefreshToken $entity): OAuthRefreshToken
    {
        if ($entity === null) {
            throw EntityNotFoundException::oauthRefreshToken();
        }

        return $entity;
    }

    private function getQueryBuilder(): \Doctrine\ORM\QueryBuilder
    {
        return $this->entityManager->getRepository(OAuthRefreshToken::class)->createQueryBuilder('OAuthRefreshToken');
    }
}
