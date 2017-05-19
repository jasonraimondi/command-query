<?php
namespace Jmondi\Gut\Action\User;

use Jmondi\Gut\Infrastructure\Lib\Query\QueryInterface;

class GetUser implements QueryInterface
{
    /** @var string */
    private $userId;

    /** @var string[] */
    private $withData;

    public function __construct(
        string $userId,
        ?array $withData = null
    ) {
        if ($withData === null) {
            $withData = [];
        }

        $this->userId = $userId;
        $this->withData = $withData;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getWithData(): array
    {
        return $this->withData;
    }
}
