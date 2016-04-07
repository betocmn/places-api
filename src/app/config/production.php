<?php
if (!defined('RDS_HOSTNAME')) {
    define('RDS_HOSTNAME', $_SERVER['RDS_HOSTNAME']);
    define('RDS_USERNAME', $_SERVER['RDS_USERNAME']);
    define('RDS_PASSWORD', $_SERVER['RDS_PASSWORD']);
    define('RDS_DB_NAME', $_SERVER['RDS_DB_NAME']);
}
return [

    'debugMode' => 0, // 0; no developer messages // 1; developer messages and CoreExceptions
    'hostName' => 'http://api-places.us-west-2.elasticbeanstalk.com/',
    'clientHostName' => 'http://api-places.us-west-2.elasticbeanstalk.com/',
    'database' => [
        'adapter' => 'Postgresql',
        'host' => RDS_HOSTNAME,
        'username' => RDS_USERNAME,
        'password' => RDS_PASSWORD,
        'name' => RDS_DB_NAME
    ]
];