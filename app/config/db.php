<?php
// Database connection settings
$host = 'localhost'; // Database host
$username = 'root'; // Database username
$password = ''; // Database password
$dbname = 'barangay_management_system'; // Your database name

// Create a connection using MySQLi
$db = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
