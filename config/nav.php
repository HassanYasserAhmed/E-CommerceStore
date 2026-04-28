<?php

return [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard',
        'title' => 'Dashboard',
    ],
    [
        'icon' => 'nav-icon fas fa-layer-group',
        'route' => 'categories.index',
        'title' => 'Categories',
        'badege' => 'New',
        'ability' => 'categories.view',
    ],
    [
        'icon' => 'nav-icon fas fa-box-open',
        'route' => 'products.index',
        'title' => 'products',
        'ability' => 'products.view',
    ],
    [
        'icon' => 'nav-icon fas fa-user-shield',
        'route' => 'roles.index',
        'title' => 'Roles',
        'active' => 'dashboard.roles.*',
        'ability' => 'roles.view',
    ],
    [
        'icon' => 'nav-icon fas fa-users-cog',
        'route' => 'admin.index',
        'title' => 'Admins',
        'active' => 'dashboard.admins.*',
        'ability' => 'admins.view',
    ],
];
