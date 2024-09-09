<?php
// Include the database connection
include('db.php');

// Now you can use the $db variable to run your queries
$query = "SELECT * FROM residents";
$result = $db->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['name']; // Example usage
    }
} else {
    echo "Error: " . $db->error;
}
