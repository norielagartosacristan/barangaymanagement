<?php
// fetch_resident.php

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barangay_management_system"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from POST request
$data = json_decode(file_get_contents('php://input'), true);
$residentID = $data['residentID'];

// Prepare and execute query
$sql = "SELECT * FROM residents WHERE ResidentID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $residentID);
$stmt->execute();
$result = $stmt->get_result();

// Check if resident found
if ($result->num_rows > 0) {
    $resident = $result->fetch_assoc();
    echo json_encode(['success' => true, 'resident' => $resident]);
} else {
    echo json_encode(['success' => false, 'message' => 'Resident not found.']);
}

$stmt->close();
$conn->close();
?>
