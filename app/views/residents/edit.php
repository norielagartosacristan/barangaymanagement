<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\header.php'; ?>
<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'barangay_management_system'; // Replace with your actual database name

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the ID is set in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $residentID = $_GET['id'];

    // Fetch resident data
    $sql = "SELECT * FROM residents WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param('i', $residentID); // Bind as integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if resident data was found
    if ($result && $result->num_rows > 0) {
        $resident = $result->fetch_assoc();
    } else {
        // Resident not found
        echo "<script>alert('Resident not found.'); window.location.href='/barangaymanagement/app/views/residents/index.php';</script>";
        exit();
    }
} else {
    // Invalid request
    echo "<script>alert('Invalid request. Resident ID is missing.'); window.location.href='/barangaymanagement/app/views/residents/index.php';</script>";
    exit();
}

// Update resident data if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $middleName = $_POST['middleName'];
    $gender = $_POST['gender'];
    $civilStatus = $_POST['civilStatus'];
    $birthdate = $_POST['birthdate'];
    $bithPlace = $_POST['birthPlace'];
    $occupation = $_POST['occupation'];
    $citizenship = $_POST['citizenship'];
    $province = $_POST['province'];
    $cityMunicipality = $_POST['cityMunicipality'];
    $barangay = $_POST['barangay'];
    $sitioZone = $_POST['sitioZone'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $voters = $_POST['voters'];
    $four_ps = $_POST['four_ps'];


    // Update resident data
    $updateSQL = "UPDATE residents SET FirstName = ?, LastName = ?, MiddleName = ?, Gender = ?, CivilStatus = ?, Birthdate = ?, BirthPlace = ?, Occupation = ?, Citizenship = ?, Province = ?, CityMunicipality = ?, Barangay = ?, SitioZone = ?, ContactNumber = ?, Email = ?, Voters = ?, Four_ps = ? WHERE ID = ?";
    $updateStmt = $conn->prepare($updateSQL);
    $updateStmt->bind_param('ssssssissssssissss', $firstName, $lastName, $middleName, $gender, $civilStatus, $birthdate, $bithPlace, $occupation, $citizenship, $province, $cityMunicipality, $barangay, $sitioZone, $contactNumber, $email, $voters, $four_ps, $residentID);

    if ($updateStmt->execute()) {
        header("Location: D:/GrsDatabase/htdocs/barangaymanagement/app/views/residents/index.php?message=Resident updated successfully");
        exit();
    } else {
        echo "Error updating resident: " . $conn->error;
    }
}
?>

<div class="main">

<div class="container mt-5">
    <h2>Edit Resident</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" value="<?= htmlspecialchars($resident['FirstName']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" value="<?= htmlspecialchars($resident['LastName']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="middleName" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middleName" name="middleName" value="<?= htmlspecialchars($resident['MiddleName']); ?>">
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="Male" <?= $resident['Gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?= $resident['Gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="civilStatus" class="form-label">Civil Status</label>
            <select class="form-control" id="civilStatus" name="civilStatus" required>
                <option value="Single" <?= $resident['CivilStatus'] === 'Single' ? 'selected' : ''; ?>>Single</option>
                <option value="Married" <?= $resident['CivilStatus'] === 'Married' ? 'selected' : ''; ?>>Married</option>
                <option value="Widow" <?= $resident['CivilStatus'] === 'Widow' ? 'selected' : ''; ?>>Widow</option>
                <option value="Separated" <?= $resident['CivilStatus'] === 'Separated' ? 'selected' : ''; ?>>Separated</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">Birthdate</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?= htmlspecialchars($resident['Birthdate']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">Birth Place</label>
            <input type="text" class="form-control" id="birthplace" name="birthplace" value="<?= htmlspecialchars($resident['BirthPlace']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">Occupation</label>
            <input type="text" class="form-control" id="occupation" name="birthplace" value="<?= htmlspecialchars($resident['Occupation']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">Citizenship</label>
            <input type="text" class="form-control" id="citizenship" name="citizenship" value="<?= htmlspecialchars($resident['Citizenship']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">Province</label>
            <input type="text" class="form-control" id="province" name="province" value="<?= htmlspecialchars($resident['Province']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">City/Municipality</label>
            <input type="text" class="form-control" id="cityMunicipality" name="cityMunicipality" value="<?= htmlspecialchars($resident['CityMunicipality']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">Barangay</label>
            <input type="text" class="form-control" id="barangay" name="Barangay" value="<?= htmlspecialchars($resident['Barangay']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">Sitio/Zone</label>
            <input type="text" class="form-control" id="sitioZone" name="sitioZone" value="<?= htmlspecialchars($resident['SitioZone']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contactNumber" name="contactNumber" value="<?= htmlspecialchars($resident['ContactNumber']); ?>">
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($resident['Email']); ?>">
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">Voters</label>
            <input type="text" class="form-control" id="voters" name="voters" value="<?= htmlspecialchars($resident['Voters']); ?>">
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">4Ps Member</label>
            <input type="text" class="form-control" id="four_ps" name="four_ps" value="<?= htmlspecialchars($resident['Four_ps']); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="/barangaymanagement/app/views/residents/index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</div>

<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\footer.php'; ?>