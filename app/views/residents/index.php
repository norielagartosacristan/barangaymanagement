<?php include 'D:/GrsDatabase/htdocs/barangaymanagement/app/views/header.php'; ?>

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
$limit = 5;  // Number of entries per page
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
    <h1>List of Residents</h1>
    <div class="searhfield">
        <div class="addbutton">
            <!-- Button to Open Modal for Adding Resident -->
            <button class="btn btn-info" id="openModalBtn">Add Resident</button>
            <button type="button" class="btn btn-primary" id="openModal">Add Household</button>
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
        <thead class="theader">
            <tr>
                <th>Image</th>
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
                    <td class="tbody-image">
                    <img src="<?php echo !empty($row['ProfileImage']) ? '\barangaymanagement\uploads\images\images' . $row['ProfileImage'] : '\barangaymanagement\uploads\images\images'; ?>" alt="Profile Image" style="width: 40px; height: 35px;">
                    </td>
                    <td class="table-cell"><?= $row['ResidentID']; ?></td>
                    <td class="table-cell"><?= $row['LastName']; ?></td>
                    <td class="table-cell"><?= $row['MiddleName']; ?></td>
                    <td class="table-cell"><?= $row['FirstName']; ?></td>
                    <td class="table-cell"><?= $row['Gender']; ?></td>
                    <td class="table-cell"><?= $row['CivilStatus']; ?></td>
                    <td class="table-cell"><?= calculate_age($row['Birthdate']); ?></td>
                    <td class="td-button">
                        <a href="\barangaymanagement\app\views\residents\residentprofile.php?id=<?= $row['ID']; ?>" class="btn btn-info btn-sm">View</a>
                        <a class="btn btn-primary edit-btn btn-sm" href="/barangaymanagement/app/views/residents/edit.php?id=<?= $row['ID']; ?>">Edit</a>
                        <a class="btn btn-danger edit-btn btn-sm" href="">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>



<?php
    // Assuming $currentPage is the current page number
    $totalPages = ceil($totalResidents / $limit);
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    if ($totalPages > 1) {
        echo '<nav aria-label="Page navigation">';
        echo '<ul class="pagination">';
        
        // Previous button
        if ($currentPage > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '&search=' . $search . '" aria-label="Previous"><span aria-hidden="true">Previous</span></a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link" aria-label="Previous"><span aria-hidden="true">&laquo;</span></span></li>';
        }

        // Page numbers with ellipsis
        $range = 2; // How many pages to show around the current page

        if ($currentPage > 1 + $range) {
            echo '<li class="page-item"><a class="page-link" href="?page=1&search=' . $search . '">1</a></li>';
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }

        for ($i = max(1, $currentPage - $range); $i <= min($totalPages, $currentPage + $range); $i++) {
            $activeClass = ($i == $currentPage) ? ' active' : '';
            echo '<li class="page-item' . $activeClass . '"><a class="page-link" href="?page=' . $i . '&search=' . $search . '">' . $i . '</a></li>';
        }

        if ($currentPage < $totalPages - $range) {
            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
            echo '<li class="page-item"><a class="page-link" href="?page=' . $totalPages . '&search=' . $search . '">' . $totalPages . '</a></li>';
        }

        // Next button
        if ($currentPage < $totalPages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '&search=' . $search . '" aria-label="Next"><span aria-hidden="true">Next</span></a></li>';
        } else {
            echo '<li class="page-item disabled"><span class="page-link" aria-label="Next"><span aria-hidden="true">&raquo;</span></span></li>';
        }

        echo '</ul>';
        echo '</nav>';
    }
?>


</div>


 <!-- Full-Screen Modal -->
 <div id="fullScreenModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add Resident</h2>
                <span class="close" id="closeModalBtn">&times;</span>
            </div>
            <div class="modal-body">
                <form class="form-group" action="add_resident.php" method="POST">
                    <div class="modal-body1">
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
                    </div>

                    <div class="modal-body1">
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
                    </div>

                    <div class="modal-body1">
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
                    </div>

                    <div class="modal-body1">
                        <div class="mb-3">
                            <label for="province" class="form-label">Province</label>
                            <input type="text" class="form-control" id="province" name="province" required>
                        </div>
                        <div class="mb-3">
                            <label for="cityMunicipality" class="form-label">City/Municipality</label>
                            <input type="text" class="form-control" id="cityMunicipality" name="cityMunicipality" required>
                        </div>
                        <div class="mb-3">
                            <label for="barangay" class="form-label">Barangay</label>
                            <input type="text" class="form-control" id="barangay" name="barangay" required>
                        </div>
                        
                    </div>
                    
                   <div class="modal-body1">
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
                   </div>
                    
                    <button type="submit" class="btn btn-success">Add Resident</button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="footer-button" id="closeModalFooterBtn">Close</button>
            </div>
        </div>
    </div>


<!-- Modal HTML -->
<div class="modal" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Add Household</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="POST" action="add_household.php">
        <label for="householdHead">Household Head (Resident ID):</label><br>
        <select name="householdHead" id="householdHead" required>
            <!-- Populate this dropdown with Resident IDs from the residents table -->
            <?php
            $query = "SELECT ResidentID, CONCAT(LastName, ' ',FirstName) AS Name FROM residents";
            $result = $db->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['ResidentID']}'>{$row['Name']}</option>";
            }
            ?>
        </select>
        <br>

        <label for="number_of_members">Number of Members:</label><br>
        <input class="form-group" type="number" name="numberOfMembers" id="numberOfMembers" required>
        <br>
        <label for="number_of_members">Sitio Address:</label><br>
        <input class="form-group" type="text" name="sitioAddress" id="sitioAddress" required><br>

        <button class="btn btn-info" type="submit">Add Household</button>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



















<!-- Bootstrap JS and Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
  // Initialize the modal
  const myModal = new bootstrap.Modal(document.getElementById('myModal'));

  // Event listener to open the modal when the button is clicked
  document.getElementById('openModal').addEventListener('click', () => {
    myModal.show(); // Show the modal
  });

  // Event listener for the "Save changes" button inside the modal
  document.getElementById('saveChanges').addEventListener('click', () => {
    alert('Changes have been saved!');
    myModal.hide(); // Hide the modal after saving
  });
</script>

<script>
    $(document).ready(function() {
        $('#residentTable').DataTable();
    });
</script>
</div>
<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\footer.php'; ?>