<?php
namespace Jmondi\Gut\Repository\OAuth;

use Doctrine\ORM\EntityManager;
use Jmondi\Gut\Entity\Exception\EntityNotFoundException;
use Jmondi\Gut\Entity\OAuth\OAuthClient;

class DoctrineOAuthClientRepository implements OAuthClientRepositoryInterface
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getById(string $oauthClientIdentifier): OAuthClient
    {
        return $this->returnOrThrowNotFoundException(
            $this->getQueryBuilder()
                ->where('OAuthClient.identifier = :OAuthClientId')
                ->setParameter('OAuthClientId', $oauthClientIdentifier)
                ->getQuery()
                ->getOneOrNullResult()
        );
    }

    public function create(OAuthClient & $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function update(OAuthClient & $entity): void
    {
        $this->assertManaged($entity);
        $this->entityManager->flush();
    }

    private function assertManaged(OAuthClient $entity)
    {
        if (! $this->entityManager->contains($entity)) {
            throw EntityNotFoundException::oauthClient();
        }
    }

    private function returnOrThrowNotFoundException(?OAuthClient $entity): OAuthClient
    {
        if ($entity === null) {
            throw EntityNotFoundException::oauthClient();
        }

        return $entity;
    }

    private function getQueryBuilder(): \Doctrine\ORM\QueryBuilder
    {
        return $this->entityManager->getRepository(OAuthClient::class)->createQueryBuilder('OAuthClient');
    }
}
