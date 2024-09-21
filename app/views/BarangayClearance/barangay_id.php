<?php
// Enable error reporting to catch issues
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection using mysqli
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "barangay_management_system"; // Replace with your database name

// Create a new mysqli connection
$db = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Initialize resident data as empty to prevent undefined variable errors
$resident = [
    'Barangay' => 'Unknown',
    'Municipality' => 'Unknown',
    'FirstName' => '',
    'MiddleName' => '',
    'LastName' => '',
    'Address' => 'Not available',
    'Birthdate' => 'Not available',
    'ResidentID' => 'Not available',
    'ProfileImage' => 'default.png', // Default image if none provided
];

// Check if 'id' is set in the query string
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $ResidentID = $_GET['id']; // Fetch the ID from the query string

    // Prepare the SQL query
    $query = "SELECT * FROM Residents WHERE ResidentID = ?";
    $stmt = $db->prepare($query);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind the parameter and execute the statement
        $stmt->bind_param("s", $ResidentID); // Using 's' for string since ResidentID is VARCHAR
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the resident data
        if ($result->num_rows > 0) {
            $resident = $result->fetch_assoc();
        } else {
            echo "Resident not found.";
        }

        // Free result and close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $db->error;
    }
} else {
    // Handle missing or empty ID
    die("Error: No Resident ID provided.");
}

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay ID</title>
    <style>
        /* Main container for ID */
        .id-container {
            width: 350px;
            height: 220px;
            border: 2px solid #000;
            border-radius: 10px;
            background-color: #f9f9f9;
            padding: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
            position: relative;
        }

        /* Header Section for Logos and Heading */
        .header-section {
            text-align: center;
            margin-bottom: 10px;
            position: relative;
        }

        /* Left logo (Barangay) */
        .header-section .logo-left {
            position: absolute;
            left: 0;
            top: 0;
            width: 60px;
            height: 60px;
        }

        /* Right logo (Municipality) */
        .header-section .logo-right {
            position: absolute;
            right: 0;
            top: 0;
            width: 60px;
            height: 60px;
        }

        /* Center heading */
        .header-section h1 {
            font-size: 16px;
            text-transform: uppercase;
            margin: 0;
            padding-top: 10px;
        }

        /* ID details container */
        .details-container {
            display: flex;
            flex-direction: row;
            margin-top: 10px;
        }

        /* Left section for profile image */
        .left-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .left-section img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #333;
        }

        /* Right section for resident details */
        .right-section {
            flex: 2;
            padding-left: 10px;
        }

        .right-section h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .right-section p {
            margin: 5px 0;
            font-size: 12px;
            line-height: 1.5;
        }

        /* Footer section for issuing info */
        .footer-section {
            text-align: center;
            font-size: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="id-container">
    <!-- Header Section for Logos and Centered Heading -->
    <div class="header-section">
        <img src="path/to/barangay_logo.png" alt="Barangay Logo" class="logo-left">
        <img src="path/to/municipality_logo.png" alt="Municipality Logo" class="logo-right">
        <h1>Barangay <?php echo htmlspecialchars($resident['Barangay']); ?></h1>
        <h2>Municipality of <?php echo htmlspecialchars($resident['Municipality']); ?></h2>
    </div>

    <!-- ID Details Container -->
    <div class="details-container">
        <!-- Left Section for Profile Image -->
        <div class="left-section">
            <img src="uploads/images/<?php echo htmlspecialchars($resident['ProfileImage']); ?>" alt="Profile Picture">
        </div>

        <!-- Right Section for Details -->
        <div class="right-section">
            <h2><?php echo htmlspecialchars($resident['FirstName'] . ' ' . $resident['MiddleName'] . ' ' . $resident['LastName']); ?></h2>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($resident['Address']); ?></p>
            <p><strong>Barangay:</strong> <?php echo htmlspecialchars($resident['Barangay']); ?></p>
            <p><strong>Municipality:</strong> <?php echo htmlspecialchars($resident['Municipality']); ?></p>
            <p><strong>Birthdate:</strong> <?php echo htmlspecialchars($resident['Birthdate']); ?></p>
            <p><strong>ID Number:</strong> <?php echo htmlspecialchars($resident['ResidentID']); ?></p>
        </div>
    </div>

    <!-- Footer Section for Barangay Details -->
    <div class="footer-section">
        <p>Issued by Barangay <?php echo htmlspecialchars($resident['Barangay']); ?></p>
        <p>Issue Date: <?php echo date('Y-m-d'); ?></p>
    </div>
</div>

</body>
</html>
