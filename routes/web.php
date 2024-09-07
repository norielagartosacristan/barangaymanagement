<?php

$authController = new AuthController($db);

// Login route
if ($_SERVER['REQUEST_URI'] == '/auth/login') {
    $authController->login();
}

// Logout route
if ($_SERVER['REQUEST_URI'] == '/auth/logout') {
    $authController->logout();
}
