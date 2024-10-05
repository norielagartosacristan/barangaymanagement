
// Check if the signature pad has been drawn on
function isSignatureDrawn() {
    const signatureData = signaturePad.toDataURL();
    return signatureData !== signaturePad.toDataURL('image/png'); // Check if the signature pad is blank
}

// Disable Generate ID button initially
generateIDButton.disabled = true;

// Enable Generate ID button only when a signature is drawn
signaturePad.addEventListener('mouseup', () => {
    if (isSignatureDrawn()) {
        generateIDButton.disabled = false;
    }
});

// Generate Barangay ID with resident details and signature
generateIDButton.addEventListener('click', () => {
    if (!isSignatureDrawn()) {
        alert('Please sign before generating the ID.');
        return;
    }

    const residentID = document.getElementById('residentID').value;

    // Fetch resident details from the server
    fetch(`fetch_resident_details.php?residentID=${residentID}`)
        .then(response => response.json())
        .then(data => {
            // Display resident details in the ID if found
            if (data.success) {
                document.getElementById('residentFullName').textContent = data.fullName;
                document.getElementById('residentAddress').textContent = data.address;
                document.getElementById('residentProvince').textContent = data.province;
                document.getElementById('residentMunicipality').textContent = data.municipality;
                document.getElementById('residentBarangay').textContent = data.barangay;
                document.getElementById('residentBirthdate').textContent = data.birthdate;
                document.getElementById('residentIDDisplay').textContent = residentID;

                // Show the ID container
                idContainer.style.display = 'block';
                printIDButton.style.display = 'block'; // Show print button

                // Display the signature
                const signatureDataUrl = signaturePad.toDataURL('image/png');
                document.getElementById('signatureImage').src = signatureDataUrl;

                // Set issue date
                const today = new Date().toLocaleDateString();
                document.getElementById('issueDate').textContent = today;
            } else {
                alert('Resident not found. Please check the Resident ID.');
            }
        })
        .catch(error => {
            console.error('Error fetching resident details:', error);
            alert('Error fetching resident details. Please try again.');
        });
});






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
        $success = true;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $db->close();
}
