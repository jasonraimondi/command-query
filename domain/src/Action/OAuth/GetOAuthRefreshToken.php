<?php
namespace Jmondi\Gut\Action\OAuth;

use Jmondi\Gut\Infrastructure\Lib\Query\QueryInterface;

class GetOAuthRefreshToken implements QueryInterface
{
    /** @var string */
    private $oAuthRefreshTokenId;

    /** @var string[] */
    private $withData;

    public function __construct(
        string $oAuthRefreshTokenId,
        ?array $withData = null
    ) {
        if ($withData === null) {
            $withData = [];
        }

        $this->oAuthRefreshTokenId = $oAuthRefreshTokenId;
        $this->withData = $withData;
    }

    public function getOAuthRefreshTokenId(): string
    {
        return $this->oAuthRefreshTokenId;
    }

    public function getWithData(): array
    {
        return $this->withData;
    }
}
