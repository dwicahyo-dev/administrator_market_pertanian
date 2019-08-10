<?php

return [
    'role_structure' => [
        'superadministrator' => [
            'agricultures' => 'c,r,s,u,d',
            'commodities' => 'c,r,s,u,d',
            'qualities' => 'c,r,s,u,d',
            'quality_of_agricultures' => 'c,r,s,u,d',
            'standard_prices' => 'c,r,s,u,d',
            'users' => 'c,r,s,u,d',
            'users_role' => 'c,r,s,u,d',
            'notifications' => 'r'
        ],
        'administrator' => [
            'agricultures' => 'r,s',
            'commodities' => 'r,s',
            'qualities' => 'r,s',
            'quality_of_agricultures' => 'r,s',
            'standard_prices' => 'c,r,s,u,d',
        ],
    ],
    'permission_structure' => [],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        's' => 'show',
        'u' => 'update',
        'd' => 'delete'
    ]
];
