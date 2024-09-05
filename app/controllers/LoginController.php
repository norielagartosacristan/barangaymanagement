<?php
class LoginController {
    public function showLoginForm() {
        require_once '../app/views/login.php';
    }

    public function authenticate() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Fetch user from database
        $user = User::findByUsername($username);

        if ($user && password_verify($password, $user->password)) {
            // Start the session and store user information
            session_start();
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['role'] = $user->role;

            // Redirect based on user role
            if ($user->role === 'admin') {
                header('Location: /public/admin/dashboard');
            } else {
                header('Location: /public/staff/dashboard');
            }
        } else {
            // Wrong credentials, return to login with error
            $error = 'Invalid username or password';
            require_once '../app/views/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /public/login');
    }
}
