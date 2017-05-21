<?php
namespace Jmondi\Gut\Infrastructure\Repository\OAuth;

use Doctrine\ORM\EntityManager;
use Jmondi\Gut\DomainModel\Entity\Uuid\Uuid;
use Jmondi\Gut\DomainModel\Exception\EntityNotFoundException;
use Jmondi\Gut\DomainModel\OAuth\OAuthAuthCode;

class DoctrineOAuthAuthCodeRepository implements OAuthAuthCodeRepositoryInterface
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getById(string $oauthRefreshTokenId): OAuthAuthCode
    {
        return $this->returnOrThrowNotFoundException(
            $this->getQueryBuilder()
                ->where('OAuthAuthCode.id = :OAuthAuthCodeId')
                ->setParameter('OAuthAuthCodeId', Uuid::fromString($oauthRefreshTokenId)->toBytes())
                ->getQuery()
                ->getOneOrNullResult()
        );
    }

    public function create(OAuthAuthCode & $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function update(OAuthAuthCode & $entity): void
    {
        $this->assertManaged($entity);
        $this->entityManager->flush();
    }

    private function assertManaged(OAuthAuthCode $entity)
    {
        if (! $this->entityManager->contains($entity)) {
            throw EntityNotFoundException::oauthAuthCode();
        }
    }

    private function returnOrThrowNotFoundException(?OAuthAuthCode $entity): OAuthAuthCode
    {
        if ($entity === null) {
            throw EntityNotFoundException::oauthAuthCode();
        }

        return $entity;
    }

    private function getQueryBuilder(): \Doctrine\ORM\QueryBuilder
    {
        return $this->entityManager->getRepository(OAuthAuthCode::class)->createQueryBuilder('OAuthAuthCode');
    }
}
