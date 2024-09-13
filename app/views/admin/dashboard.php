<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\header.php'; ?>

<div class="main">

<?php
// Database connection details
include 'D:/GrsDatabase/htdocs/barangaymanagement/app/config/db.php';

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


      <div class="main-content">
          <form action="/barangaymanagement/public/login.php" method="POST" style="display: inline;">
          <button class="btn btn-success" type="submit">Logout</button>
          </form>
          <p id="clock"></p>
      </div>

        <div class="wrapper-main">
            <h1 class="population">Total Population: <?php echo $total_residents; ?><br><p class="population-date">As of <?php echo $current_date; ?></p></h1>
            <div class="col-div-4-1">
                    <div class="box-households">
                        <p class="head-1">Total Households</p>
                        <p class="number"><?php echo $total_residents; ?></p>
                        
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

<script>
// JavaScript function to start the clock
function startClock() {
    // Set the initial time from PHP
    let now = new Date(<?php echo time() * 1000; ?>); // PHP provides the current time in seconds, multiply by 1000 to convert to milliseconds for JavaScript

    // Function to update the clock every second
    function updateClock() {
        now.setSeconds(now.getSeconds() + 1); // Increment seconds by 1

        // Get the current date and time
        let hours = now.getHours().toString().padStart(2, '0');
        let minutes = now.getMinutes().toString().padStart(2, '0');
        let seconds = now.getSeconds().toString().padStart(2, '0');
        let ampm = hours >= 12 ? 'PM' : 'AM';

        // Convert to 12-hour format
        hours = hours % 12;
        hours = hours ? hours : 12; // If hour is 0, set to 12

        // Get the month, day, and year
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        let month = monthNames[now.getMonth()];
        let day = now.getDate();
        let year = now.getFullYear();

        // Format the date as Month Day, Year
        let formattedDate = `${month} ${day}, ${year}`;

        // Display the current time and date
        document.getElementById('clock').textContent = formattedDate + ' ' + hours + ':' + minutes + ':' + seconds + ' ' + ampm;
    }

    // Start the clock immediately
    updateClock();
    // Update the clock every 1000 milliseconds (1 second)
    setInterval(updateClock, 1000);
}

// Call the function to start the clock
startClock();
</script>



<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\footer.php'; ?>