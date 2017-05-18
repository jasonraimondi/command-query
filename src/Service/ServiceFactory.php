<?php
namespace Jmondi\Gut\Service;

use Doctrine\ORM\Repository\RepositoryFactory;

class ServiceFactory
{
    /** @var RepositoryFactory */
    protected $repositoryFactory;

    public function __construct(RepositoryFactory $repositoryFactory)
    {
        $this->repositoryFactory = $repositoryFactory;
    }
}
