<?php
session_start();

// Database connection setup (assuming $conn is your MySQLi connection)
require_once '\barangaymanagement\app\config\db.php';
require_once '..controllers/AuthController.php';

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    // Login Route
    case '/barangaymanagement/login.php':
        $authController = new AuthController($conn);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $authController->login($username, $password);
        } else {
            require 'views/login.php';
        }
        break;

    // Logout Route
    case '/barangaymanagement/logout':
        $authController = new AuthController($conn);
        $authController->logout();
        break;

    // Admin Dashboard Route
    case '/barangaymanagement/admin/dashboard':
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header('Location: /barangaymanagementg/login');
            exit;
        }
        require 'views/admin.php';
        break;

    // Staff Dashboard Route
    case '/barangaymanagement/staff/dashboard':
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'staff') {
            header('Location: /barangaymanagement/login');
            exit;
        }
        require 'views/staff.php';
        break;

    // Other Protected Routes
    case '/barangaymanagement/protected-page':
        if (!isset($_SESSION['user_role'])) {
            header('Location: /barangaymanagement/login');
            exit;
        }
        require 'views/protected-page.php';
        break;

    // Default Route
    default:
        http_response_code(404);
        echo "404 - Page not found.";
        break;
}

$conn->close();




 // Include the database connection
require_once '\barangaymanagement\app\controllers\ResidentController.php'; // Include the ResidentController

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '\barangaymanagement\app\controllers\ResidentController.php':
        $controller = new ResidentController($db);
        $controller->index();
        break;

    // Other routes...

    default:
        http_response_code(404);
        echo "404 - Page not found.";
        break;
}

$conn->close(); // Close the database connection
?>



echo "Resident added successfully!";