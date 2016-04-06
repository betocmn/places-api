<?php

return [

    'application' => [
        'baseUri' => '/',
        'viewsDir' => __DIR__ . '/../views/',
    ],

    'authentication' => [
        'secret' => 'u71u2aie#aeLKJ&hakw_098efBagealjH156zV!9087',
        'expirationTime' => 86400 * 7, // One week till token expires
    ],

    'acl' => [
        'publicEndpoints' => [
            '/',
            '/users',
            '/users/authenticate'
        ],
        'privateEndpoints' => [
            '/places/search/{location}/{type}',
        ],
    ],

];
