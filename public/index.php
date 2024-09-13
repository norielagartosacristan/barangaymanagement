<?php
// Get the URL from the rewrite rule
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'index';

$url = filter_var($url, FILTER_SANITIZE_URL);

// Separate the URL into segments
$url_parts = explode('/', $url);

// Assuming the first part of the URL is the page or controller
$page = $url_parts[0];

// Route to the correct view or controller
if ($page == 'residents') {
    require 'app/views/residents.php'; // Direct to the residents view
} elseif ($page == 'dashboard') {
    require 'app/views/dashboard.php'; // Direct to the dashboard view
} else {
    require 'D:\GrsDatabase\htdocs\barangaymanagement\public\login.php'; // Default to home page
}
