<?php
namespace Jmondi\Gut\Lib\Query;

interface QueryBusInterface
{
    /**
     * @param QueryInterface $query
     * @return void
     */
    public function execute(QueryInterface $query);
}
