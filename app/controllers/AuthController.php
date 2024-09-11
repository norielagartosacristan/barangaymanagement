<?php

// app/controllers/AuthController.php
session_start();
require_once '/includes/db.php';
require_once '../app/models/User.php';

class AuthController {
    private $db;
    private $userModel;

    // Constructor: Ensure the User class is instantiated correctly
    public function __construct($db) {
        $this->db = $db;  // use the global database connection
        $this->userModel = new User($db);  // Create an instance of the User model
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];  // Changed from 'email' to 'username'
            $password = $_POST['password'];

            if (empty($username) || empty($password)) {
                echo "Username and password are required!";
                return;
            }

            // Call the method on the user model instance
            $user = $this->userModel->findUserByUsername($username);  // Call on instance, not statically

            if ($user && password_verify($password, $user['password'])) {
                // Password matches, log the user in
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect to dashboard
                header("Location: ../public/dashboard.php");
            } else {
                echo "Invalid username or password.";
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ../public/login.php");
    }
}
