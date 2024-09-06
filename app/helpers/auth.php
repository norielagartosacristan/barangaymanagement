<?php
function checkLogin() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        // If the user is not logged in, redirect to the login page
        header('Location: /public/login.php');
        exit(); // Stop further script execution
    }
}
