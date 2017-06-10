<?php

$app->get('/', [
    'as' => 'home',
    'uses' => 'ImplicitController@index'
]);

$app->get('/assets/{templateNamespace}/{path}', [
    'as' => 'asset.serve',
    'uses' => 'AssetController@serve'
]);
