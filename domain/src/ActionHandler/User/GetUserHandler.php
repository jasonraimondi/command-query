<?php
namespace Jmondi\Gut\ActionHandler\User;

use Jmondi\Gut\Action\User\GetUser;
use Jmondi\Gut\DomainModel\User\User;
use Jmondi\Gut\Infrastructure\Authorization\AuthorizationContextInterface;
use Jmondi\Gut\Infrastructure\Lib\Query\QueryHandlerInterface;
use Jmondi\Gut\Infrastructure\Repository\User\UserRepositoryInterface;

final class GetUserHandler implements QueryHandlerInterface
{
    /** @var GetUser */
    private $query;

    /** @var UserRepositoryInterface */
    private $userRepository;

    public function __construct(
        GetUser $query,
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
        $this->query = $query;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAuthenticated();
    }

    public function execute(): User
    {
        return $this->userRepository->getById(
            $this->query->getUserId()
        );
    }
}
