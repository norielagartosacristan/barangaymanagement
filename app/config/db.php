<?php
// Database connection settings
$host = 'localhost'; // Database host
$dbname = 'your_database_name'; // Your database name
$username = 'root'; // Database username
$password = ''; // Database password

// Create a connection using MySQLi
$db = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
