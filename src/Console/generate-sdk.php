<?php

use Jmondi\Gut\ApiClientLibrary\ApiClientLibraryGenerator;

require_once realpath(__DIR__ . '/../../') . '/vendor/autoload.php';

$typeDescriber = new ApiClientLibraryGenerator();
$typeDescriber->someting();
