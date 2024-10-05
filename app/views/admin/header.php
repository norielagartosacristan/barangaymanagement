<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="\barangaymanagement\public\css\dashboard.css">
    <link rel="stylesheet" href="\barangaymanagement\public\css\style.css">
    <link rel="stylesheet" href="\barangaymanagement\assets\css\css\bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"> 
</head>
<body>
 
<div id="container">

<div class="sidebar">
    <nav class="nav flex-column">
        <a class="nav-link" href="/barangaymanagement/app/views/admin/dashboard.php">
            <span class="icon">
                <i class="bi bi-grid"></i>
            </span>
            <span class="description">Dashboard</span>
        </a>

        <!-- menu for barangay personnel -->
        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#submenu1" araia-expand="false" arai-controls="submenu">
            <span class="icon">
                <i class="bi bi-box-seam"></i>
            </span>
            <span class="description">Barangay Personnel Tool <i class="bi bi-caret-down-fill"></i></span>
         </a>
        
             <!-- menu for resident -->
            <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#submenu3" araia-expand="false" arai-controls="submenu">
                <span class="icon">
                    <i class="bi bi-box-seam"></i>
                </span>
                <span class="description">Resident Tool <i class="bi bi-caret-down-fill"></i></span>
            </a>
            <!-- submenu for clearance tool -->
            <div class="sub-menu collapse" id="submenu3">
                <a class="nav-link" href="/barangaymanagement/app/views/residents/index.php">
                    <span class="icon">
                        <i class="bi bi-file-earmark-check"></i>
                    </span>
                    <span class="description">List of Resident</span>
                </a>
            </div> 


          <!-- menu with dropdown -->
          <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#submenu2" araia-expand="false" arai-controls="submenu">
            <span class="icon">
                <i class="bi bi-box-seam"></i>
            </span>
            <span class="description">Clearance & Cert. Tool <i class="bi bi-caret-down-fill"></i></span>
         </a>
          <!-- submenu for clearance tool -->
          <div class="sub-menu collapse" id="submenu2">
            <a class="nav-link" href="/barangaymanagement/app/views/BarangayClearance/barangayclearance_form.php">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">Barangay Clearance</span>
            </a>
            <a class="nav-link" href="#">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">Business Clearance</span>
            </a>
            <a class="nav-link" href="#">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">Certificate of Residency</span>
            </a>
            <a class="nav-link" href="#">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">Certificate of Indigency</span>
            </a>
            <a class="nav-link" href="\barangaymanagement\app\views\BarangayID\barangay.php">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">Barangay ID</span>
            </a>
         </div>
    </nav>
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
