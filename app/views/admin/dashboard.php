<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\admin\header.php'; ?>

<?php
if ($_SESSION['user_role'] != 'admin') {
    header('Location: public/login.php');
    exit;
}
?>


<div class="main">

<?php
// Database connection details
include 'D:/GrsDatabase/htdocs/barangaymanagement/app/config/db.php';

// Query to count total residents
$total_household_query = "SELECT COUNT(*) AS household FROM household";
$total_result = $db->query($total_household_query);
$total_household = $total_result->fetch_assoc()['household'];


// Query to count total residents
$total_residents_query = "SELECT COUNT(*) AS total FROM residents";
$total_result = $db->query($total_residents_query);
$total_residents = $total_result->fetch_assoc()['total'];

// Query to count male residents
$male_residents_query = "SELECT COUNT(*) AS males FROM residents WHERE gender = 'Male'";
$male_result = $db->query($male_residents_query);
$male_residents = $male_result->fetch_assoc()['males'];

// Query to count female residents
$female_residents_query = "SELECT COUNT(*) AS females FROM residents WHERE gender = 'Female'";
$female_result = $db->query($female_residents_query);
$female_residents = $female_result->fetch_assoc()['females'];

$db->close();

// Get current month and year
$current_date = date('F Y'); // Outputs current month and year in format like 'September 2024'
?>


 
        <div class="wrapper-main">
            <h1 class="population">Total Population: <?php echo $total_residents; ?><br><p class="population-date">As of <?php echo $current_date; ?></p></h1>

            <div class="col-div-4-1">
                    <div class="box-households">
                        <p class="head-1">Households</p>
                        <p class="number"><?php echo $total_household; ?></p>
                        <i class="fa fa-line-chart box-icon"></i>
                    </div>
            </div>

            <div class="col-div-4-1">
                    <div class="box-households">
                        <p class="head-1">Families</p>
                        <p class="number"><?php echo $total_household; ?></p>
                        <i class="fa fa-line-chart box-icon"></i>
                    </div>
            </div>


            <div class="col-div-4-1">
                    <div class="box-residents">
                        <p class="head-1">Residents</p>
                        <p class="number"><?php echo $total_residents; ?></p>
                        <i class="fa fa-line-chart box-icon"></i>
                    </div>
            </div>

            <div class="col-div-4-1">
                    <div class="box-male">
                        <p class="head-1">Male</p>
                        <p class="number"><?php echo $male_residents; ?></p>
                        <i class="fa fa-line-chart box-icon"></i>
                    </div>
            </div>

            <div class="col-div-4-1">
                    <div class="box-female">
                        <p class="head-1">Female</p>
                        <p class="number"><?php echo $female_residents; ?></p>
                        <i class="fa fa-line-chart box-icon"></i>
                    </div>
            </div>
        </div> 
        
        <div class="container">
            <div class="column left">
                <h2></h2>
                <p></p>
            </div>


            <div class="column right">
                <h2>Population/Sitio</h2>
                <div class="scrollable-content">
                    <div class="content-" id="population-data">
                    <!-- Population data will be dynamically inserted here -->
                    </div>
                </div>
            </div>


        </div>

</div>


<script>
    function fetchPopulationData() {
    fetch('/barangaymanagement/app/views/admin/fetch_population_by_sitio.php')
        .then(response => response.json())
        .then(data => {
            const populationContainer = document.getElementById('population-data');
            populationContainer.innerHTML = ''; // Clear existing data

            data.forEach(sitio => {
                const sitioDiv = document.createElement('div');
                sitioDiv.classList.add('population-item');
                sitioDiv.innerHTML = `
                    <h2>${sitio.SitioZone}</h2>
                    <h1>Total <span>${sitio.total}</span></h1>
                    <h1>Male <span>${sitio.male_count}</span></h1>
                    <h1>Female <span>${sitio.female_count}</span></h1>
                    <h1>Jobless <span>${sitio.jobless_count}</span></h1>
                `;
                populationContainer.appendChild(sitioDiv);
            });
        })
        .catch(error => console.error('Error fetching population data:', error));
}

fetchPopulationData();
</script>

<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\footer.php'; ?>