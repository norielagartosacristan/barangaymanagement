<?php
session_start();
if ($_SESSION['role'] !== 'staff') {
    header('Location: /auth/login');
    exit();
}
?>

<h1>Welcome to the Staff Dashboard, <?php echo $_SESSION['username']; ?>!</h1>
<a href="/auth/logout">Logout</a>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
</head>
<body>
    <h1>Welcome Staff</h1>
    <a href="/public/logout">Logout</a>
</body>
</html>
