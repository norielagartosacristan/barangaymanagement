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
    $sitioAddress = $_POST['sitioAddress'];


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

        $insertQuery = "INSERT INTO household (HouseholdNumber, HouseholdHead, NumberOfMembers, SitioAddress) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($insertQuery);
        $stmt->bind_param("isis", $householdNumber, $householdHead, $numberOfMembers, $sitioAddress);

        if ($stmt->execute()) {
            // Set a success flag to display the success message
            $success = true;
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Resident Management</title>
    <style>
        /* Style for the modal and button */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-content h2 {
            margin: 0 0 10px;
            color: #28a745;
        }

        .modal-content button {
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .modal-content button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<!-- Success Modal -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <h2>Success!</h2>
        <p>New household added successfully with household number <?php echo $householdNumber ?></p>
        <button id="doneButton">Done</button>
    </div>
</div>

<script>
    // Function to show the success message
    function showSuccessMessage() {
        const modal = document.getElementById('successModal');
        modal.style.display = 'flex'; // Show the modal
    }

    // Close the modal when the Done button is clicked
    document.getElementById('doneButton').addEventListener('click', function () {
        const modal = document.getElementById('successModal');
        modal.style.display = 'none'; // Hide the modal
        // Redirect to the desired page
        window.location.href = '/barangaymanagement/app/views/residents/index.php'; // Replace with your target page URL
    });

    // PHP block to show the modal when the success flag is set
    <?php if (isset($success) && $success): ?>
    showSuccessMessage();
    <?php endif; ?>
</script>

</body>
</html>
