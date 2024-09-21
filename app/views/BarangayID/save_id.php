<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barangay_management_system";

$db = new mysqli($servername, $username, $password, $dbname);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Get the ResidentID and image data from the form
$residentID = $_POST['residentID'];
$imageData = $_POST['image'];

if (!$residentID || !$imageData) {
    die("Resident ID or image data is missing.");
}

// Decode and save the image
$imageData = str_replace('data:image/png;base64,', '', $imageData);
$imageData = str_replace(' ', '+', $imageData);
$decodedImage = base64_decode($imageData);
$imageName = 'profile_' . time() . '.png';
$imagePath = 'D:\GrsDatabase\htdocs\barangaymanagement\uploads\images' . $imageName;

if (!file_put_contents($imagePath, $decodedImage)) {
    die("Failed to save image.");
}

// Fetch resident details from the database
$query = "SELECT * FROM Residents WHERE ResidentID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $residentID);
$stmt->execute();
$result = $stmt->get_result();
$resident = $result->fetch_assoc();

if (!$resident) {
    die("Resident not found.");
}

// Prepare data for Barangay ID
$barangayName = $resident['Barangay'];
$municipalityName = $resident['CityMunicipality'];
$fullName = $resident['FirstName'] . ' ' . $resident['MiddleName'] . ' ' . $resident['LastName'];
$address = $resident['Barangay'];
$birthdate = $resident['Birthdate'];

// Display Barangay ID
echo "
<script>
    document.getElementById('barangayId').style.display = 'block';
    document.getElementById('barangayName').innerText = '$barangayName';
    document.getElementById('municipalityName').innerText = '$municipalityName';
    document.getElementById('residentFullName').innerText = '$fullName';
    document.getElementById('residentBarangay').innerText = '$address';
    document.getElementById('residentBarangay').innerText = '$barangayName';
    document.getElementById('residentMunicipality').innerText = '$municipalityName';
    document.getElementById('residentBirthdate').innerText = '$birthdate';
    document.getElementById('residentIDDisplay').innerText = '$residentID';
    document.getElementById('issuedBarangay').innerText = '$barangayName';
    document.getElementById('residentPhoto').src = '$imagePath';
</script>
";
?>
<button onclick="window.print()">Print ID</button>
<a href="generate_id.php">Back</a>
