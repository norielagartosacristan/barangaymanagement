<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\header.php'; ?>
<?php include('D:\GrsDatabase\htdocs\barangaymanagement\app\config\db.php'); ?>
<?php

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
        $profileImage = !empty($resident['ProfileImage']) ? 'uploads/images' . $resident['ProfileImage'] : 'uploads/default.jpeg';
    } else {
        echo "Resident not found.";
        exit();
    }
} else {
    echo "No resident ID provided.";
    exit();
}
?>

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


<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\footer.php'; ?>