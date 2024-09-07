<?php
// Database connection
$db = new mysqli('localhost', 'root', '', 'barangay_management_system');

// Check if the connection was successful
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Function to calculate age based on birthdate
function calculateAge($birthdate) {
    $dob = new DateTime($birthdate);
    $now = new DateTime();
    $age = $now->diff($dob)->y;
    return $age;
}

// Function to generate a unique ResidentID (8 digits)
function generateResidentID($db) {
    do {
        $unique_id = mt_rand(10000000, 99999999); // Generate an 8-digit number

        // Check if ResidentID is unique
        $query = "SELECT ResidentID FROM residents WHERE ResidentID = ?";
        $stmt = $db->prepare($query);
        if (!$stmt) {
            die("Error preparing query: " . $db->error);
        }
        $stmt->bind_param('s', $unique_id);
        $stmt->execute();
        $stmt->store_result();
    } while ($stmt->num_rows > 0); // Repeat if ID already exists

    $stmt->close();
    return $unique_id;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $lastName = $_POST['lastName'] ?? '';
    $middleName = $_POST['middleName'] ?? '';
    $firstName = $_POST['firstName'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $civilStatus = $_POST['civilStatus'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';
    $birthPlace = $_POST['birthPlace'] ?? '';
    $occupation = $_POST['occupation'] ?? '';
    $citizenship = $_POST['citizenship'] ?? '';
    $cityMunicipality = $_POST['cityMunicipality'] ?? '';
    $barangay = $_POST['barangay'] ?? '';
    $sitioZone = $_POST['sitioZone'] ?? '';
    $contactNumber = $_POST['contactNumber'] ?? '';
    $email = $_POST['email'] ?? '';

    // Input validation (basic example, you can expand this as needed)
    if (empty($lastName) || empty($firstName) || empty($birthdate)) {
        die("Please fill out all required fields (Last Name, First Name, Birthdate).");
    }

    // Auto-generate ResidentID
    $residentID = generateResidentID($db);

    // Calculate age
    $age = calculateAge($birthdate);

    // Prepare the SQL query to insert into the database
    $query = "INSERT INTO residents 
              (ResidentID, LastName, MiddleName, FirstName, Gender, CivilStatus, Birthdate, Age, BirthPlace, Occupation, Citizenship, CityMunicipality, Barangay, SitioZone, ContactNumber, Email) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $db->prepare($query);
    
    if (!$stmt) {
        die("Error preparing statement: " . $db->error);
    }

    // Bind parameters to the query
    $stmt->bind_param('sssssssissssssss', $residentID, $lastName, $middleName, $firstName, $gender, $civilStatus, $birthdate, $age, $birthPlace, $occupation, $citizenship, $cityMunicipality, $barangay, $sitioZone, $contactNumber, $email);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        echo "Resident added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $db->close();
}
?>
