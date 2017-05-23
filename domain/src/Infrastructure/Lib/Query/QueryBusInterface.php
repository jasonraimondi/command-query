<?php
namespace Jmondi\Gut\Infrastructure\Lib\Query;

interface QueryBusInterface
{
    public function execute(QueryInterface $query): ResponseInterface;
}
