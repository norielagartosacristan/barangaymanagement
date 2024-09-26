<?php
// Include necessary files for header and database connection
include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\header.php';
include('D:\GrsDatabase\htdocs\barangaymanagement\app\config\db.php');

// Fetch the resident's details based on the resident ID passed to the URL
if (isset($_GET['id'])) {
    $residentID = $_GET['id'];

    // Prepare the SQL query to get resident details
    $query = "SELECT * FROM Residents WHERE ID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $residentID);
    $stmt->execute();
    $result = $stmt->get_result();
    $resident = $result->fetch_assoc();

    if (!$resident) {
        echo "Resident not found.";
        exit();
    }
} else {
    echo "No resident ID provided.";
    exit();
}

// Profile Image Path
$profileImage = !empty($resident['ProfileImage']) ? '/barangaymanagement/uploads/images/images' . $resident['ProfileImage'] : '/barangaymanagement/uploads/images/images';
?>

<!-- Profile Display -->
<div class="profile-container">
    <div class="profile-header">
        <!-- Display Profile Image -->
        <img src="<?php echo $profileImage; ?>" alt="Profile Image" id="profileImagePreview">

        <div class="profile-info">
            <h1><?php echo $resident['FirstName'] . ' ' . $resident['MiddleName'] . ' ' . $resident['LastName']; ?></h1>
            <p><strong>Resident ID:</strong> <?php echo $resident['ResidentID']; ?></p>
            <p><strong>Gender:</strong> <?php echo $resident['Gender']; ?></p>
            <p><strong>Age:</strong> <?php echo $resident['Age']; ?></p>
            <p><strong>Birthdate:</strong> <?php echo $resident['Birthdate']; ?></p>
        </div>
    </div>

    <div class="profile-details">
        <h3>Resident Details</h3>
        <div class="profile-body">
            <div>
                <p><strong>Occupation:</strong> <?php echo $resident['Occupation']; ?></p>
                <p><strong>Civil Status:</strong> <?php echo $resident['CivilStatus']; ?></p>
                <p><strong>Birthplace:</strong> <?php echo $resident['BirthPlace']; ?></p>
            </div>
            <div>
                <p><strong>Citizenship:</strong> <?php echo $resident['Citizenship']; ?></p>
                <p><strong>Province:</strong> <?php echo $resident['Province']; ?></p>
                <p><strong>Municipality:</strong> <?php echo $resident['CityMunicipality']; ?></p>
            </div>
            <div>
                <p><strong>Barangay:</strong> <?php echo $resident['Barangay']; ?></p>
                <p><strong>Sitio/Zone:</strong> <?php echo $resident['SitioZone']; ?></p>
                <p><strong>Contact Number:</strong> <?php echo $resident['ContactNumber']; ?></p>
            </div>
            <p><strong>Email:</strong> <?php echo $resident['Email']; ?></p>
        </div>
    </div>

    <!-- Take Photo Button -->
    <button id="takePhotoButton">Take Photo</button>
    <button id="saveCaptureButton" style="display: none;">Save Captured Image</button>
    <video id="cameraStream" autoplay style="display:none;"></video>
    <canvas id="snapshotCanvas" style="display:none;"></canvas>
</div>

<!-- JavaScript for Camera Capture and Save -->
<script>
document.getElementById('takePhotoButton').addEventListener('click', function() {
    const video = document.getElementById('cameraStream');
    const canvas = document.getElementById('snapshotCanvas');
    const saveCaptureButton = document.getElementById('saveCaptureButton');

    // Request access to the user's camera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.style.display = 'block';
            video.srcObject = stream;

            // Capture the photo when the video is clicked
            video.addEventListener('click', () => {
                canvas.style.display = 'block';
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

                // Stop the video stream
                stream.getTracks().forEach(track => track.stop());
                video.style.display = 'none'; // Hide the video after capturing

                // Convert the captured image to a data URL
                const dataURL = canvas.toDataURL('image/png');
                document.getElementById('profileImagePreview').src = dataURL;
                saveCaptureButton.dataset.imageData = dataURL;
                saveCaptureButton.style.display = 'block'; // Show save button
            });
        })
        .catch(error => {
            console.error('Error accessing the camera: ', error);
            alert('Could not access the camera.');
        });
});

document.getElementById('saveCaptureButton').addEventListener('click', function() {
    const dataURL = this.dataset.imageData;
    const residentID = '<?php echo $residentID; ?>';

    // Send the captured image data to the server
    fetch('/barangaymanagement/app/views/residents/upload_image.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ imageData: dataURL, resident_id: residentID }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Image captured and uploaded successfully!');
            document.getElementById('profileImagePreview').src = dataURL; // Update the profile image preview
        } else {
            alert('Failed to upload image: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error uploading captured image: ', error);
        alert('Error uploading captured image.');
    });
});
</script>

<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\footer.php'; ?>
