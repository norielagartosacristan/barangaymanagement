<?php
// app/views/dashboard.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

echo "Welcome to the dashboard, " . $_SESSION['username'];
?>

<a href="logout.php">Logout</a>



<?php
// Include the database connection
include('/app/config/Database.php');

// Fetch total residents
$totalResidentsQuery = "SELECT COUNT(*) AS total FROM residents";
$result = $conn->query($totalResidentsQuery);
$totalResidents = $result->fetch_assoc()['total'];

// Fetch residents per sitio
$residentsPerSitioQuery = "SELECT COUNT(*) AS total FROM residents WHERE sitio = 'Sitio 1'";
$result = $conn->query($residentsPerSitioQuery);
$residentsPerSitio = $result->fetch_assoc()['total'];

// Fetch male residents
$maleResidentsQuery = "SELECT COUNT(*) AS total FROM residents WHERE gender = 'Male'";
$result = $conn->query($maleResidentsQuery);
$maleResidents = $result->fetch_assoc()['total'];

// Fetch female residents
$femaleResidentsQuery = "SELECT COUNT(*) AS total FROM residents WHERE gender = 'Female'";
$result = $conn->query($femaleResidentsQuery);
$femaleResidents = $result->fetch_assoc()['total'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="\barangaymanagement\public\css\css\bootstrap.min.css">
</head>
<body>
    <h1>Welcome Admin</h1>
    <a href="/public/logout">Logout</a>
    <p>Hello World</p>



  <div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-white" id="sidebar-wrapper" style="width: 250px; position: fixed; height: 100%;">
      <div class="sidebar-heading text-center py-4 fs-4">
        Barangay Dashboard
      </div>
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">Dashboard</a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">Residents</a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">Blotter</a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">Officials</a>
      </div>
    </div>

    <!-- Main content -->
    <div id="page-content-wrapper" style="margin-left: 250px;">
      <!-- Header -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Barangay Dashboard</a>
        </div>
      </nav>

      <!-- Main Content -->
      <div class="container-fluid mt-5">
        <div class="row">
          <!-- Total Residents -->
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-primary text-white">
              <div class="card-body">
                <h4>Total Residents</h4>
                <h2 id="totalResidents">0</h2>
              </div>
            </div>
          </div>
          
          <!-- Residents per Sitio -->
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-success text-white">
              <div class="card-body">
                <h4>Residents per Sitio</h4>
                <h2 id="residentsPerSitio">0</h2>
              </div>
            </div>
          </div>
          
          <!-- Male Residents -->
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-info text-white">
              <div class="card-body">
                <h4>Male Residents</h4>
                <h2 id="maleResidents">0</h2>
              </div>
            </div>
          </div>
          
          <!-- Female Residents -->
          <div class="col-lg-3 col-md-6 mb-4">
            <div class="card bg-warning text-white">
              <div class="card-body">
                <h4>Female Residents</h4>
                <h2 id="femaleResidents">0</h2>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Bar Chart -->
        <div class="row">
          <div class="col-lg-12">
            <canvas id="residentChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

  <!-- Chart.js Script -->
  <script>
    const ctx = document.getElementById('residentChart').getContext('2d');
    const residentChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Total Residents', 'Sitio 1', 'Sitio 2', 'Male', 'Female'],
        datasets: [{
          label: '# of Residents',
          data: [100, 30, 20, 60, 40],  // Update with dynamic values later
          backgroundColor: [
            'rgba(75, 192, 192, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(75, 192, 192, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</body>
