<?php
namespace Jmondi\Gut\App;

use Doctrine\ORM\EntityManager;

final class ApplicationCore
{
    /** @var array */
    private $doctrineDbParams;

    public function __construct(array $doctrineDbParams)
    {
        $this->doctrineDbParams = $doctrineDbParams;
    }

    private function getEntityManager(): EntityManager
    {
        static $entityManager = null;

        if ($entityManager === null) {
            $entityManager = $this->getNewEntityManager();
        }

        return $entityManager;
    }

    private function getNewEntityManager(): EntityManager
    {
        $doctrineHelper = new DoctrineHelper(
            $this->getCacheDriver(),
            $this->getMetadataCacheDriver(),
            $this->getQueryCacheDriver(),
            $this->autoGenerateProxyClasses
        );
        $doctrineHelper->setup($this->dbParams);

        return $doctrineHelper->getEntityManager();
    }
}
