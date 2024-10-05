<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barangay_management_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL query to fetch population data grouped by SitioZone
$sql = "SELECT SitioZone, 
               COUNT(*) AS total, 
               SUM(CASE WHEN Gender = 'Male' THEN 1 ELSE 0 END) AS male_count,
               SUM(CASE WHEN Gender = 'Female' THEN 1 ELSE 0 END) AS female_count,
               SUM(CASE WHEN Occupation = 'none' THEN 1 ELSE 0 END) AS jobless_count
        FROM residents
        GROUP BY SitioZone";

$result = $conn->query($sql);

$populationData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $populationData[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($populationData);
?>
