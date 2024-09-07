<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
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





    <div class="container">
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>Resident ID</th>
                    <th>Last Name</th>
                    <th>Middle Name</th>
                    <th>First Name</th>
                    <th>Gender</th>
                    <th>Civil Status</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php

                    $query = "SELECT * FROM residents";

                    $result = mysqli_query($connection, $query);

                    if (!$result) {
                        die("query Failed".mysqli_error());
                    } else {
                        while($row = mysqli_fetch_assoc($result)) {
                            ?>

                <tr>
                    <td><?php echo $row['ResidentID']; ?></td>
                    <td><?php echo $row['LastName']; ?></td>
                    <td><?php echo $row['MiddleName']; ?></td>
                    <td><?php echo $row['FirstName']; ?></td>
                    <td><?php echo $row['Gender']; ?></td>
                    <td><?php echo $row['BirthDate']; ?></td>
                    <td><?php echo $row['ContactNumber']; ?></td>
                    <td>
                        <button>Edit</button>
                        <button>View</button>
                        <button>Delete</button>
                    </td>
                </tr>  

                            <?php
                        }
                    }

                ?>

                <tr>
                    <td>2024-0845</td>
                    <td>Sacristan</td>
                    <td>Lagarto</td>
                    <td>Noriel</td>
                    <td>Male</td>
                    <td>Single</td>
                    <td>Sitio Sinturisan, GRS, Ragay, Camarines Sur</td>
                    <td>
                        <button>Edit</button>
                        <button>View</button>
                        <button>Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>