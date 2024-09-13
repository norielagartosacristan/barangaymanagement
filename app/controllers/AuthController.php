<?php
session_start();
require_once 'D:\GrsDatabase\htdocs\barangaymanagement\app\config\db.php'; // Include your database connection
require_once 'D:\GrsDatabase\htdocs\barangaymanagement\app\models\User.php';

class AuthController {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Function to authenticate user based on username and password
    public function login($username, $password) {
        // Prepare SQL to fetch the user by username
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Store session data
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];

                // Redirect based on user role
                if ($user['role'] == 'admin') {
                    header('Location: \barangaymanagement\app\views\admin\dashboard.php');
                    exit;
                } elseif ($user['role'] == 'staff') {
                    header('Location: /staff/dashboard.php');
                    exit;
                } else {
                    // If role is unknown, redirect to login with an error
                    $_SESSION['error'] = "Invalid user role.";
                    header('Location: \barangaymanagement\public\login.php');
                    exit;
                }
            } else {
                // If password doesn't match, redirect back to login
                $_SESSION['error'] = "Invalid password.";
                header('Location: \barangaymanagement\public\login.php');
                exit;
            }
        } else {
            // If no user found, redirect back to login
            $_SESSION['error'] = "User not found.";
            header('Location: \barangaymanagement\public\login.php');
            exit;
        }
    }

    // Function to handle logout
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /barangaymanagement/public/login.php');
        exit;
    }
}

// Instantiate AuthController and handle the login request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Initialize the database connection using MySQLi
    $db = new mysqli('localhost', 'root', '', 'barangay_management_system');

    if ($db->connect_error) {
        die('Connection failed: ' . $db->connect_error);
    }

    // Create an instance of AuthController
    $authController = new AuthController($db);

    // Attempt to log the user in
    $authController->login($username, $password);
} elseif (isset($_GET['logout'])) {
    // Handle logout if the logout parameter is present
    $authController = new AuthController(null); // No need for DB for logout
    $authController->logout();
}
