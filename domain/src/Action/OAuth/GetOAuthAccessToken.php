<?php
namespace Jmondi\Gut\Action\OAuth;

use Jmondi\Gut\Infrastructure\Lib\Query\QueryInterface;

class GetOAuthAccessToken implements QueryInterface
{
    /** @var string */
    private $oAuthAccessTokenId;

    /** @var string[] */
    private $withData;

    public function __construct(
        string $oAuthAccessTokenId,
        ?array $withData = null
    ) {
        if ($withData === null) {
            $withData = [];
        }

        $this->oAuthAccessTokenId = $oAuthAccessTokenId;
        $this->withData = $withData;
    }

    public function getOAuthAccessTokenId(): string
    {
        return $this->oAuthAccessTokenId;
    }

    public function getWithData(): array
    {
        return $this->withData;
    }
}
