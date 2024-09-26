<?php
// Database connection (update with your credentials)
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'barangay_management_system';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $residentID = $_POST['residentID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $birthdate = $_POST['birthdate'];

    // Update resident data
    $sql = "UPDATE residents SET FirstName = ?, LastName = ?, Birthdate = ? WHERE ResidentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $firstName, $lastName, $birthdate, $residentID);

    if ($stmt->execute()) {
        echo "Resident data updated successfully.";
    } else {
        echo "Error updating resident data: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
