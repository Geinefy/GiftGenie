<?php

// routes/web.php

// This file is a simple mapping that mirrors the React routes in the frontend.

return [
    '/' => ['controller' => 'HomeController@index', 'name' => 'home'],
    '/gifts' => ['controller' => 'GiftsController@index', 'name' => 'gifts'],
    '/dashboard' => ['controller' => 'HomeController@dashboard', 'name' => 'dashboard'],
    '/auth' => ['controller' => 'AuthController@index', 'name' => 'auth'],
];
