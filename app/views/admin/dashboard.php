<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\header.php'; ?>

<?php
if ($_SESSION['user_role'] != 'admin') {
    header('Location: public/login.php');
    exit;
}
// Prevent 
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
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
                        <p class="head-1">Total Households</p>
                        <p class="number"><?php echo $total_household; ?></p>
                        <i class="fa fa-line-chart box-icon"></i>
                    </div>
            </div>

            <div class="col-div-4-1">
                    <div class="box-households">
                        <p class="head-1">Total Families</p>
                        <p class="number"><?php echo $total_household; ?></p>
                        <i class="fa fa-line-chart box-icon"></i>
                    </div>
            </div>


            <div class="col-div-4-1">
                    <div class="box-residents">
                        <p class="head-1">Total Residents</p>
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
            
</div>



<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\footer.php'; ?>