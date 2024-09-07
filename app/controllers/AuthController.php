<?php
require_once '../app/models/User.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Find user by username
            $user = $this->userModel->findByUsername($username);
            
            if ($user && password_verify($password, $user->password)) {
                // Start session
                session_start();
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['role'] = $user->role;

                // Redirect based on role
                if ($user->role == 'admin') {
                    header('Location: /admin/dashboard');
                } else {
                    header('Location: /staff/dashboard');
                }
                exit();
            } else {
                echo "Invalid login credentials!";
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /login');
    }
}
