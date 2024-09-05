<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to the login page
    header('Location: login.php');
    exit();
}

// If the user is logged in, include the necessary files and proceed with the application
require_once '../config/Database.php'; // Adjust the path if needed
require_once '../app/controllers/SomeController.php'; // Adjust the path if needed

// Initialize your application here (e.g., routing, etc.)
