<?php

$router->get('/login', 'LoginController@showLoginForm');
$router->post('/login/authenticate', 'LoginController@authenticate');
$router->get('/logout', 'LoginController@logout');

