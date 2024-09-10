<?php

// web.php (Routing file)

require_once '../app/controllers/AuthController.php';

$authController = new AuthController();

if ($_SERVER['REQUEST_URI'] == '/login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $authController->login();  // Handle login
}

if ($_SERVER['REQUEST_URI'] == '/logout') {
    $authController->logout();  // Handle logout
}
