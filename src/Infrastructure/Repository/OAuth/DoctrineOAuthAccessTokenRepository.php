<?php
namespace Jmondi\Gut\Infrastructure\Repository\OAuth;

use Doctrine\ORM\EntityManager;
use Jmondi\Gut\DomainModel\Exception\EntityNotFoundException;
use Jmondi\Gut\DomainModel\OAuth\OAuthAccessToken;
use Jmondi\Gut\DomainModel\OAuth\OAuthAccessTokenException;

class DoctrineOAuthAccessTokenRepository implements OAuthAccessTokenRepositoryInterface
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getById(string $oauthAccessTokenId): OAuthAccessToken
    {
        return $this->returnOrThrowNotFoundException(
            $this->getQueryBuilder()
                ->where('OAuthAccessToken.identifier = :identifier')
                ->setParameter('identifier', $oauthAccessTokenId)
                ->getQuery()
                ->getOneOrNullResult()
        );
    }

    public function create(OAuthAccessToken & $entity): void
    {
        if ($entity instanceof OAuthAccessToken) {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } else {
            throw OAuthAccessTokenException::incorrectEntityType();
        }
    }

    public function update(OAuthAccessToken & $entity): void
    {
        if ($entity instanceof OAuthAccessToken) {
            $this->assertManaged($entity);
            $this->entityManager->flush();
        } else {
            throw OAuthAccessTokenException::incorrectEntityType();
        }
    }

    private function assertManaged(OAuthAccessToken $entity)
    {
        if (! $this->entityManager->contains($entity)) {
            throw EntityNotFoundException::oauthAccessToken();
        }
    }

    private function returnOrThrowNotFoundException(?OAuthAccessToken $entity): OAuthAccessToken
    {
        if ($entity === null) {
            throw EntityNotFoundException::oauthAccessToken();
        }

        return $entity;
    }

    private function getQueryBuilder(): \Doctrine\ORM\QueryBuilder
    {
        return $this->entityManager->getRepository(OAuthAccessToken::class)->createQueryBuilder('OAuthAccessToken');
    }
}
