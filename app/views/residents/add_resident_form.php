<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Resident</title>
    <!-- Optional: You can include Bootstrap for better styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Resident</h2>
        <form action="add_resident.php" method="POST">
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
            <button type="submit" class="btn btn-primary">Add Resident</button>
        </form>
    </div>
</body>
</html>
