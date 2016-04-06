<?php
/*
 * Loads all required modules
 *
 * @author: Humberto Moreira <humberto.mn@gmail.com>
 */

$appPath = __DIR__ . '/../';
$vendorPath = __DIR__ . '/../../vendor/';

// Requires Composer autoload
require_once $vendorPath . 'autoload.php';

$loader = new \Phalcon\Loader();

$loader->registerDirs([
    $appPath . 'collections/',
    $appPath . 'controllers/',
    $appPath . 'models/',
    $appPath . 'transformers/',
    $appPath . 'views/'
]);

$loader->registerNamespaces([
    'App' => $appPath . 'library/App'
]);

$loader->register();
