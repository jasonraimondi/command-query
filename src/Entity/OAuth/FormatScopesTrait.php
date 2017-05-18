<?php
namespace Jmondi\Gut\Entity\OAuth;

trait FormatScopesTrait
{
    /**
     * @param OAuthScope[] $scopes
     * @return string
     */
    public function formatScopesForStorage(array $scopes): string
    {
        return json_encode($this->scopesToArray($scopes));
    }

    /**
     * @param OAuthScope[] $scopes
     * @return array
     */
    public function scopesToArray(array $scopes): array
    {
        $ids = [];

        foreach ($scopes as $scope) {
            $ids[] = $scope->getId();
        }

        return $ids;
    }
}
