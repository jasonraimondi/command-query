<?php
namespace Jmondi\Gut\Service\OAuth;

use Jmondi\Gut\Entity\LeagueOAuth2Server\Entity\LeagueUserEntity;
use Jmondi\Gut\Entity\Uuid\Uuid;
use Jmondi\Gut\Entity\User\PasswordException;
use Jmondi\Gut\Repository\User\UserRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface as LeagueUserRepositoryInterface;

class LeagueUserService implements LeagueUserRepositoryInterface
{
    /** @var UserRepositoryInterface */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $userId
     * @param string $password
     * @param string $grantType The grant type used
     * @param ClientEntityInterface $clientEntity
     * @return UserEntityInterface
     * @throws PasswordException
     */
    public function getUserEntityByUserCredentials(
        $userId,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ): UserEntityInterface
    {
        $user = $this->userRepository->getById(Uuid::fromString($userId));

        if ($user->isValidPassword($password)) {
            return LeagueUserEntity::createFromUser($user);
        }

        throw PasswordException::invalidAccess();
    }
}
