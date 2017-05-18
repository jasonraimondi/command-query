<?php
namespace Jmondi\Gut\ActionHandler\User;

use Jmondi\Gut\Action\User\GetUser;
use Jmondi\Gut\Entity\User\User;
use Jmondi\Gut\Lib\Autorization\AuthorizationContextInterface;
use Jmondi\Gut\Lib\Query\QueryHandlerInterface;
use Jmondi\Gut\Repository\User\UserRepositoryInterface;

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
        $authorizationContext->verifyCanAccessUser($this->query->getUserId());
    }

    public function execute(): User
    {
        return $this->userRepository->getById(
            $this->query->getUserId()
        );
    }
}
