<?php
// Database connection
include 'D:/GrsDatabase/htdocs/barangaymanagement/app/config/db.php';


// Function to generate a 6-digit HouseholdNumber
function generateHouseholdNumber($db) {
    $number = rand(1000, 9999);
    // Ensure the generated number is unique
    $query = "SELECT HouseholdNumber FROM household WHERE HouseholdNumber = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $number);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        // Recursively generate if the number already exists
        return generateHouseholdNumber($db);
    }
    return $number;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $householdHead = $_POST['householdHead'];
    $numberOfMembers = $_POST['numberOfMembers'];

    // Check if FamilyHeadID exists in the residents table
    $query = "SELECT ResidentID FROM residents WHERE ResidentID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $householdHead);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Resident not found, return an error message
        echo "Error: Household head with Resident ID $householdHead does not exist.";
    } else {
        // Generate HouseholdNumber and insert family record
        $householdNumber = generateHouseholdNumber($db);

        $insertQuery = "INSERT INTO household (HouseholdNumber, HouseholdHead, NumberOfMembers) VALUES (?, ?, ?)";
        $stmt = $db->prepare($insertQuery);
        $stmt->bind_param("isi", $householdNumber, $householdHead, $numberOfMembers);

        if ($stmt->execute()) {
            echo "New Household added successfully with Household Number: $householdNumber";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>
