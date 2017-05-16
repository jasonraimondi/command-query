<?php
namespace Jmondi\Gut\Entity\DateTime;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Event\PreUpdateEventArgs;

trait UpdatedAtTrait
{
    /** @var int */
    protected $updatedAt;

    /**
     * @param DateTime $updated
     */
    public function setUpdatedAt(DateTime $updated = null)
    {
        if ($updated === null) {
            $updated = new DateTime('now', new DateTimeZone('UTC'));
        }
        $this->updatedAt = $updated->getTimestamp();
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt()
    {
        if (empty($this->updatedAt)) {
            return null;
        }
        $updatedAt = new DateTime();
        $updatedAt->setTimestamp($this->updatedAt);
        return $updatedAt;
    }

    public function preUpdate(PreUpdateEventArgs $event = null)
    {
        $this->setUpdatedAt();
    }
}
