<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="\barangaymanagement\assets\css\css\bootstrap.min.css">
    <link rel="stylesheet" href="\barangaymanagement\public\css\style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


</head>
<body>
<div id="container">

<div class="sidebar">
    <header>GRS</header>
    <ul>
        <li><a href="\barangaymanagement\app\views\admin\dashboard.php">Dashboard</a></li>
        <li><a href="">Barangay Officials</a></li>
        <li><a href="\barangaymanagement\app\views\residents\index.php">List of Residents</a></li>
        <li><a href="">Utility Worker</a></li>
        <li><a href="">Barangay Tanod</a></li>
        <li><a href="">BNS</a></li>
        <li><a href="">Business Permit</a></li>
        <li><a href="">Barangay Clearance</a></li>
    </ul>
</div>

<div class="container-dashboard">
            <div class="dashboard-header">
                <h2>GRS</h2>
            </div>
            <div class="clock">
                <p id="clock"></p>
            </div>
            <div class="logout-button">
                <form action="/barangaymanagement/public/login.php" method="POST" style="display: inline;">
                    <button class="btn btn-success" type="submit">Logout</button>
                </form>
            </div>
</div>

