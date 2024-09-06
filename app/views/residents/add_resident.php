<?php
// Database connection

// Function to calculate age based on birthdate
function calculateAge($birthdate) {
    $dob = new DateTime($birthdate);
    $now = new DateTime();
    $age = $now->diff($dob)->y;
    return $age;
}

// Function to generate a unique ResidentID (You can modify this format as needed)
function generateResidentID($db) {
    $prefix = 'RES-';
    $unique_id = uniqid($prefix);

    // Ensure ResidentID is unique
    $query = "SELECT * FROM residents WHERE ResidentID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $unique_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Generate new ResidentID if it already exists
    while ($result->num_rows > 0) {
        $unique_id = uniqid($prefix);
        $stmt->bind_param('s', $unique_id);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    return $unique_id;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $lastName = $_POST['lastName'];
    $middleName = $_POST['middleName'];
    $firstName = $_POST['firstName'];
    $gender = $_POST['gender'];
    $civilStatus = $_POST['civilStatus'];
    $birthdate = $_POST['birthdate'];
    $birthPlace = $_POST['birthPlace'];
    $occupation = $_POST['occupation'];
    $citizenship = $_POST['citizenship'];
    $cityMunicipality = $_POST['cityMunicipality'];
    $barangay = $_POST['barangay'];
    $sitioZone = $_POST['sitioZone'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];

    // Connect to the database
    $db = new mysqli('localhost', 'root', '', 'barangay_management_system');
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Auto-generate ResidentID
    $residentID = generateResidentID($db);

    // Calculate age
    $age = calculateAge($birthdate);

    // Insert into database
    $query = "INSERT INTO residents (ResidentID, LastName, MiddleName, FirstName, Gender, CivilStatus, Birthdate, Age, BirthPlace, Occupation, Citizenship, CityMunicipality, Barangay, SitioZone, ContactNumber, Email) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sssssssissssssss', $residentID, $lastName, $middleName, $firstName, $gender, $civilStatus, $birthdate, $age, $birthPlace, $occupation, $citizenship, $cityMunicipality, $barangay, $sitioZone, $contactNumber, $email);

    if ($stmt->execute()) {
        echo "Resident added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
