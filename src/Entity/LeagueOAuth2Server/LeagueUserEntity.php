<?php
namespace Jmondi\Gut\Entity\LeagueOAuth2Server;

use Jmondi\Gut\Entity\User\User;
use League\OAuth2\Server\Entities\UserEntityInterface;

class LeagueUserEntity extends User implements UserEntityInterface
{
    public static function createFromUser(User $user)
    {
        return new self(
            $user->getEmail(),
            $user->getId()
        );
    }
    /**
     * Return the user's identifier.
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->getId();
    }
}