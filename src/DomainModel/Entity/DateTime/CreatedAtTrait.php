<?php
namespace Jmondi\Gut\DomainModel\Entity\DateTime;

use DateTime;
use DateTimeZone;

trait CreatedAtTrait
{
    /** @var int */
    protected $createdAt;

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt = null)
    {
        if ($createdAt === null) {
            $createdAt = new DateTime('now', new DateTimeZone('UTC'));
        }
        $this->createdAt = $createdAt->getTimestamp();
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        $createdAt = new DateTime();
        $createdAt->setTimestamp($this->createdAt);
        return $createdAt;
    }
}