<?php
// public/index.php
require_once '../app/controllers/AuthController.php';
require_once '../includes/db.php';

$auth = new AuthController();

// Redirect to login view
header("Location: login.php");
