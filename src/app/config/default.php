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
            '/places/search',
            '/places/recommendations',
        ],
    ],

    'factualApi' => [
        'key' => 'zmGmtW8FhQDwPttG4HoC0BGq7yaiKm6ahDo4VlQT',
        'secret' => 'xpjwra54yZgax2LKtDab7f2JUwyhDZJk89ZaZBOO',
        'categories' => '312,338'
    ],

    'googleGeocodeApi' => [
        'key' => 'AIzaSyCx4RMUQ79q7diWUzhstJXLQbNf6oliwGg',
        'locale' => null,
        'region' => null,
        'ssl' => false
    ]

];
