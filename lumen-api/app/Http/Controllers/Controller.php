<?php
namespace Jmondi\Api\Http\Controllers;

use Jmondi\Gut\Infrastructure\Lib\ApplicationCore;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function __construct()
    {
        $appCore = new ApplicationCore([
            'driver' => 'pdo_sqlite',
            'path' => realpath(__DIR__ . '../../database') . '/db.sqlite',
        ]);

        echo '<pre>';
        dd($appCore);
    }
}
