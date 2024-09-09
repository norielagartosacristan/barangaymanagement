<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/public/css/bootsrap.min.css">
</head>
<body>






<?php
// Assuming this is part of your dashboard.php file

// Connect to the database
$db = new mysqli('localhost', 'root', '', 'barangay_management_system');

// Check for database connection errors
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Query to retrieve residents with dynamically calculated age
$query = "SELECT ResidentID, FirstName, LastName, Birthdate, TIMESTAMPDIFF(YEAR, Birthdate, CURDATE()) AS Age FROM residents";
$result = $db->query($query);

// Check if any residents were returned
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Resident ID</th><th>First Name</th><th>Last Name</th><th>Age</th></tr>";

    // Loop through the results and display each resident
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['ResidentID'] . "</td>";
        echo "<td>" . $row['FirstName'] . "</td>";
        echo "<td>" . $row['LastName'] . "</td>";
        echo "<td>" . $row['Age'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No residents found.";
}

// Close the database connection
$db->close();
?>



</body>
</html>