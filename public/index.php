<?php
session_start();

require_once '../app/controllers/AuthController.php';
require_once '../app/config/Database.php';
require_once '../routes/web.php';

// Database connection
$db = new mysqli('localhost', 'root', '', 'barangay_management_system');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
