<?php
namespace Jmondi\Gut\Infrastructure\Lib\Query;

interface QueryBusInterface
{
    /**
     * @param QueryInterface $query
     * @return void
     */
    public function execute(QueryInterface $query);
}
