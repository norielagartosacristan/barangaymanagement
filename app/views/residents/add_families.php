<?php
// Database connection
include 'D:/GrsDatabase/htdocs/barangaymanagement/app/config/db.php';


// Function to generate a 6-digit HouseholdNumber
function generateFamilyID($db) {
    $number = rand(1000, 9999);
    // Ensure the generated number is unique
    $query = "SELECT FamilyID FROM families WHERE FamilyID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $number);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        // Recursively generate if the number already exists
        return generateFamilyID($db);
    }
    return $number;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $familydHead = $_POST['familyHead'];
    $address = $_POST['Address'];
    $numberOfMembers = $_POST['numberOfMembers'];

    // Check if FamilyHeadID exists in the residents table
    $query = "SELECT ResidentID FROM residents WHERE ResidentID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $familyHead);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Resident not found, return an error message
        echo "Error: Family head with Resident ID $familyHead does not exist.";
    } else {
        // Generate HouseholdNumber and insert family record
        $householdNumber = generateHouseholdNumber($db);

        $insertQuery = "INSERT INTO families (FamilyID, FamilyHead, Address, NumberOfMembers) VALUES (?, ?, ?)";
        $stmt = $db->prepare($insertQuery);
        $stmt->bind_param("isi", $familyID, $familyHead, $address, $numberOfMembers);

        if ($stmt->execute()) {
            echo "New Family added successfully with Family Number: $familyID";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
