<?php
namespace Jmondi\Gut\Entity\Id;

trait IdentifierTrait
{
    /** @var string */
    private $identifier;

    public function setIdentifierToken(?string $identifier = null)
    {
        if ($identifier === null) {
            $identifier = bin2hex(random_bytes(40));
        }

        $this->identifier = (string) $identifier;
    }
}
