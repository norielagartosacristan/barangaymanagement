<?php
// public/index.php
require_once '../app/controllers/AuthController.php';

$auth = new AuthController();

// Redirect to login view
header("Location: login.php");
