<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header('Location: /auth/login');
    exit();
}
?>

<h1>Welcome to the Admin Dashboard, <?php echo $_SESSION['username']; ?>!</h1>
<a href="/auth/logout">Logout</a>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome Admin</h1>
    <a href="/public/logout">Logout</a>
    <p>Hello World</p>
</body>
</html>

