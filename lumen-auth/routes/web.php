<?php


$app->get('/assets/{templateNamespace}/{path}', [
    'as' => 'asset.serve',
    'uses' => 'AssetController@serve'
]);

$app->group(
    [
        'namespace' => 'OAuth',
        'prefix' => 'oauth'
    ],
    function () use ($app) {
        $app->get('/', [
            'as' => 'home',
            'uses' => 'ImplicitController@index'
        ]);
    }
);
