<?php
// app/controllers/AuthController.php
session_start();
require_once '../includes/dbh.inc.php';
require_once '../app/models/User.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct() {
        global $db;  // use the global database connection
        $this->userModel = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                echo "Email and password are required!";
                return;
            }

            $user = $this->userModel->findUserByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // Redirect to dashboard
                header("Location: ../app/views/admin/dashboard.php");
            } else {
                echo "Invalid email or password.";
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ../public/login.php");
    }
}
?>
