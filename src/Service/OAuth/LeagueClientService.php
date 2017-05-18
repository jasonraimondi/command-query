<?php
namespace Jmondi\Gut\Service\OAuth;

use Jmondi\Gut\Repository\OAuth\OAuthClientRepositoryInterface;
use Jmondi\Gut\Entity\LeagueOAuth2Server\LeagueClientEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class LeagueClientService implements ClientRepositoryInterface
{
    /** @var OAuthClientRepositoryInterface */
    private $clientRepository;

    public function __construct(
        OAuthClientRepositoryInterface $clientRepository
    ) {
        $this->clientRepository = $clientRepository;
    }

    /**
     * Get a client.
     *
     * @param string $clientIdentifier The client's identifier
     * @param string $grantType The grant type used
     * @param null|string $clientSecret The client's secret (if sent)
     * @param bool $mustValidateSecret If true the client must attempt to validate the secret if the client
     *                                        is confidential
     *
     * @return ClientEntityInterface
     */
    public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true)
    {
        $client = $this->clientRepository->getById($clientIdentifier);
        return LeagueClientEntity::createFromOAuthClient($client);
    }
}
