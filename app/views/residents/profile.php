<?php
// Include your database connection
include('D:\GrsDatabase\htdocs\barangaymanagement\app\config\db.php'); // Make sure this file contains the connection to your database

// Fetch the resident's details based on the resident ID passed to the URL
if (isset($_GET['id'])) {
    $residentID = $_GET['id'];

    // Prepare the SQL query to get resident details
    $query = "SELECT * FROM Residents WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $residentID);
    $stmt->execute();
    $result = $stmt->get_result();
    $resident = $result->fetch_assoc();

    if ($resident) {
        // Resident data found, display the profile
        $profileImage = !empty($resident['ProfileImage']) ? 'uploads/' . $resident['ProfileImage'] : 'uploads/default.png';
    } else {
        echo "Resident not found.";
        exit();
    }
} else {
    echo "No resident ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .profile-container {
            width: 60%;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
        }
        .profile-header {
            display: flex;
            align-items: center;
        }
        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-right: 20px;
        }
        .profile-info {
            flex-grow: 1;
        }
        .profile-info h1 {
            margin: 0;
        }
        .profile-info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <div class="profile-header">
        <!-- Display Profile Image -->
        <img src="<?php echo $profileImage; ?>" alt="Profile Image">

        <div class="profile-info">
            <h1><?php echo $resident['FirstName'] . $resident['MiddleName'] . $resident['LastName']; ?></h1>
            <p><strong>Resident ID:</strong> <?php echo $resident['ResidentID']; ?></p>
            <p><strong>Gender:</strong> <?php echo $resident['Gender']; ?></p>
            <p><strong>Age:</strong> <?php echo $resident['Age']; ?></p>
            <p><strong>Birthdate:</strong> <?php echo $resident['Birthdate']; ?></p>
        </div>
    </div>

    <div class="profile-details">
        <h3>Resident Details</h3>
        <p><strong>Occupation:</strong> <?php echo $resident['Occupation']; ?></p>
        <p><strong>Civil Status:</strong> <?php echo $resident['CivilStatus']; ?></p>
        <p><strong>Birthplace:</strong> <?php echo $resident['Birthplace']; ?></p>
        <p><strong>Citizenship:</strong> <?php echo $resident['Citizenship']; ?></p>
        <p><strong>Municipality:</strong> <?php echo $resident['CityMunicipality']; ?></p>
        <p><strong>Barangay:</strong> <?php echo $resident['Barangay']; ?></p>
        <p><strong>Sitio/Zone:</strong> <?php echo $resident['SitioZone']; ?></p>
        <p><strong>Contact Number:</strong> <?php echo $resident['ContactNumber']; ?></p>
        <p><strong>Email:</strong> <?php echo $resident['Email']; ?></p>
    </div>
</div>

</body>
</html>
