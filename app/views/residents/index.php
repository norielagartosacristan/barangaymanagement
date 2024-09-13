<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\header.php'; ?>

<div class="main">


<?php
include 'D:/GrsDatabase/htdocs/barangaymanagement/app/config/db.php';

// Handle form submission (Add new resident)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastName = $_POST['lastName'] ?? '';
    $middleName = $_POST['middleName'] ?? '';
    $firstName = $_POST['firstName'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $civilStatus = $_POST['civilStatus'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';
    $birthPlace = $_POST['birthPlace'] ?? '';
    $occupation = $_POST['occupation'] ?? '';
    $citizenship = $_POST['citizenship'] ?? '';
    $cityMunicipality = $_POST['cityMunicipality'] ?? '';
    $barangay = $_POST['barangay'] ?? '';
    $sitioZone = $_POST['sitioZone'] ?? '';
    $contactNumber = $_POST['contactNumber'] ?? '';
    $email = $_POST['email'] ?? '';

    // Insert query to add a new resident
    $insertQuery = "INSERT INTO residents (ResidentID, LastName, MiddleName, FirstName, Gender, CivilStatus, BirthDate, BirthPlace, Occupation, Citizenship, CityMunicipality, Barangay, SitioZone, ContactNumber, Email) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($insertQuery);
    $stmt->bind_param('sssssssssssssss', $residentID, $lastName, $middleName, $firstName, $gender, $civilStatus, $birthdate, $birthplace, $occupation, $citizenship, $cityMunicipality, $barangay, $sitioZone, $contactNumber, $email);
    $stmt->execute();
}

// Pagination and search variables
$limit = 6;  // Number of entries per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch total records
$totalQuery = "SELECT COUNT(*) AS total FROM residents WHERE CONCAT(lastname, ' ', firstname) LIKE ?";
$stmt = $db->prepare($totalQuery);
$searchTerm = '%' . $search . '%';
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$totalResult = $stmt->get_result()->fetch_assoc();
$totalResidents = $totalResult['total'];

// Fetch residents with pagination
$query = "SELECT * FROM residents WHERE CONCAT(lastname, ' ', firstname) LIKE ? LIMIT ? OFFSET ?";
$stmt = $db->prepare($query);
$stmt->bind_param("sii", $searchTerm, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

function calculate_age($birthdate) {
    $birthDate = new DateTime($birthdate);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    return $age;
}

?>
 
<div class="container mt-4">
    <h1>List of Resident</h1>
    <div class="searhfield">
        <div class="addbutton">
            <!-- Button to Open Modal for Adding Resident -->
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addResidentModal">Add Resident</button>
        </div>
        <div class="searchbutton">
             <!-- Search form -->
            <form method="GET" action="" class="form-inline mb-3">
                <input type="text" name="search" class="form-control mr-2" placeholder="Search residents" value="<?= htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-secondary">Search</button>
            </form>
        </div>
    </div>
    

    <!-- Resident Table -->
    <table id="residentTable" class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>Profile Pic</th>
                <th>Resident ID</th>
                <th>Last Name</th>
                <th>Middle Name</th>
                <th>First Name</th>
                <th>Gender</th>
                <th>Civil Status</th>
                <th>Age</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['ResidentID']; ?></td>
                    <td><?= $row['ResidentID']; ?></td>
                    <td><?= $row['LastName']; ?></td>
                    <td><?= $row['MiddleName']; ?></td>
                    <td><?= $row['FirstName']; ?></td>
                    <td><?= $row['Gender']; ?></td>
                    <td><?= $row['CivilStatus']; ?></td>
                    <td><?= calculate_age($row['Birthdate']); ?></td>
                    <td>
                        <a href="D:\GrsDatabase\htdocs\barangaymanagement\app\views\residents\edit.phpview.php?id=<?= $row['ID']; ?>" class="btn btn-info btn-sm">View</a>
                        <a href="D:\GrsDatabase\htdocs\barangaymanagement\app\views\residents\edit.phpedit.php?id=<?= $row['ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Pagination -->

<?php
    // Assuming $currentPage is the current page number
    $totalPages = ceil($totalResidents / $limit);
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    if ($totalPages > 1) {
        echo '<nav aria-label="Page navigation">';
        echo '<ul class="pagination">';
        
        // Previous button
        if ($currentPage > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '&search=' . $search . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link" aria-label="Previous"><span aria-hidden="true">&laquo;</span></span></li>';
        }

        // Page numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $currentPage) ? ' active' : '';
            echo '<li class="page-item' . $activeClass . '"><a class="page-link" href="?page=' . $i . '&search=' . $search . '">' . $i . '</a></li>';
        }

        // Next button
        if ($currentPage < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '&search=' . $search . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link" aria-label="Next"><span aria-hidden="true">&raquo;</span></span></li>';
        }

        echo '</ul>';
        echo '</nav>';
    }
?>

</div>


<!-- Modal for Adding Resident -->
<div class="modal fade" id="addResidentModal" tabindex="-1" aria-labelledby="addResidentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addResidentModalLabel">Add Resident</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form class="form-group" action="add_resident.php" method="POST">
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
            </div>
            <div class="mb-3">
                <label for="middleName" class="form-label">Middle Name</label>
                <input type="text" class="form-control" id="middleName" name="middleName">
            </div>
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="civilStatus" class="form-label">Civil Status</label>
                <select class="form-select" id="civilStatus" name="civilStatus" required>
                    <option value="" disabled selected>Select Civil Status</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widow">Widow</option>
                    <option value="Separated">Separated</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" required>
            </div>
            <div class="mb-3">
                <label for="birthPlace" class="form-label">Birth Place</label>
                <input type="text" class="form-control" id="birthPlace" name="birthPlace" required>
            </div>
            <div class="mb-3">
                <label for="occupation" class="form-label">Occupation</label>
                <input type="text" class="form-control" id="occupation" name="occupation" required>
            </div>
            <div class="mb-3">
                <label for="citizenship" class="form-label">Citizenship</label>
                <input type="text" class="form-control" id="citizenship" name="citizenship" required>
            </div>
            <div class="mb-3">
                <label for="cityMunicipality" class="form-label">City/Municipality</label>
                <input type="text" class="form-control" id="cityMunicipality" name="cityMunicipality" required>
            </div>
            <div class="mb-3">
                <label for="barangay" class="form-label">Barangay</label>
                <input type="text" class="form-control" id="barangay" name="barangay" required>
            </div>
            <div class="mb-3">
                <label for="sitioZone" class="form-label">Sitio/Zone</label>
                <input type="text" class="form-control" id="sitioZone" name="sitioZone" required>
            </div>
            <div class="mb-3">
                <label for="contactNumber" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contactNumber" name="contactNumber">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <button type="submit" class="btn btn-success">Add Resident</button>
        </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#residentTable').DataTable();
    });
</script>



</div>



<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\footer.php'; ?>