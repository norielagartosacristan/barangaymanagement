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
    $province = $_POST['province'] ?? '';
    $citizenship = $_POST['citizenship'] ?? '';
    $province = $_POST['province'] ?? '';
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
              (ResidentID, LastName, MiddleName, FirstName, Gender, CivilStatus, Birthdate, Age, BirthPlace, Occupation, Citizenship, Province, CityMunicipality, Barangay, SitioZone, ContactNumber, Email) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $db->prepare($query);
    
    if (!$stmt) {
        die("Error preparing statement: " . $db->error);
    }

    // Bind parameters to the query
    $stmt->bind_param('sssssssisssssssss', $residentID, $lastName, $middleName, $firstName, $gender, $civilStatus, $birthdate, $age, $birthPlace, $occupation, $citizenship, $province, $cityMunicipality, $barangay, $sitioZone, $contactNumber, $email);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        // Set a success flag to display the success message
        $success = true;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $db->close();
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
        <h2>Added Successfully!</h2>
        <p>Resident added successfully with resident id number <?php echo $residentID ?></p>
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
