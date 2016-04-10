<?php
/*
 * Defines which config file to use
 *
 * @author: Humberto Moreira <humberto.mn@gmail.com>
 */

if(!isset($application_env)){
    $local_config_file = __DIR__ . "/../app/config/local.php";
    $application_env = file_exists($local_config_file) ? 'development' : 'production';
}
switch ($application_env) {

    case 'production':
        $serverConfig = require_once __DIR__ . "/../config/production.php";
        break;
    case 'development':
    default:
        $serverConfig = require_once __DIR__ . "/../config/local.php";
        break;
}

$defaultConfig = require_once __DIR__ . "/../config/default.php";
$config = array_merge($defaultConfig, $serverConfig);

return new \Phalcon\Config($config);
