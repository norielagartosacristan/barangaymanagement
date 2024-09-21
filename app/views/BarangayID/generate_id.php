<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\header.php'; ?>


<div class="main">



    <style>
        /* Styling the form and capture section */
        #video {
            width: 320px;
            height: 240px;
            border: 1px solid blue;
            margin-top: 10px;
        }
        #canvas {
            display: none; /* Hidden until capture */
        }
        #photo {
            display: none; /* Hidden until capture */
            width: 320px;
            height: 240px;
            border: 1px solid black;
            margin-top: 10px;
        }
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
            display: none; /* Initially hidden until photo is taken */
            margin-top: 20px;
        }
        .logo-left {
            height: 52px;
            width: 52px;
        }
        .logo-right {
            height: 50px;
            width: 50px;
            float: right;
        }
        .header-brgyid {
            font-size: 15px;
            text-align: center;
            line-height: 8px;
        }
        .header-section {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-around;
        }
        .details-container {
            display: flex;
            flex-direction: row;
        }
        .residentName {
            font-size: 10px;
            line-height: 2px;
        }
        .footer-section {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: flex-end;
            margin-top: 40px;
            font-size: 11px;
        
        }
        .header-brgyid-main h1 {
            line-height: 2px;
            font-size: 12px;
        }
        .footer-brgyid {
            line-height: 2px;
            font-size: 11px;
        }
        .right-section {
            margin-left: 10px;
            margin-top: 5px;
        }
        .right-section-div1 {
            display: flex;
            flex-direction: row;
            gap: 50px;
        }
        .left-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .footer-brgyid-1 {
            font-size: 11px;
            line-height: 2px;
        }
        .footer-brgycaptan {
            font-size: 10px;
            text-align: center;
            line-height: 2px;
        }
        .residentFullName {
            font-size: 12px;
            line-height: 2px;
        }
        .imageID {
            width: 60px;
            height: 60px;
        }
    </style>

<h2>Generate Barangay ID</h2>

<form id="idForm" method="POST" enctype="multipart/form-data" action="save_id.php">
    <label for="residentID">Resident ID:</label>
    <input type="text" id="residentID" name="residentID" required>
    <br><br>

    <!-- Video stream for camera capture -->
    <video id="video" autoplay></video>
    <br>
    <button type="button" id="capture">Capture Photo</button>
    <button type="button" id="reset">Reset</button>
    <canvas id="canvas" width="320" height="240"></canvas>
    <br>
    <img id="photo" alt="Captured Photo">
    <br><br>

    <!-- Hidden input to hold captured image data -->
    <input type="hidden" name="image" id="imageData">

    <button type="submit">Generate ID</button>
</form>

<!-- Container for displaying generated Barangay ID -->
<div class="id-container" id="barangayId">
    <div class="header-section">
        <div>
            <img src="\barangaymanagement\uploads\images\grslogo.jpg" alt="Barangay Logo" class="logo-left">
        </div>
        <div>
            <h1 class="header-brgyid">Province of Camarines Sur</h1>
            <h1 class="header-brgyid">Municipality of Ragay</h1>
            <h1 class="header-brgyid">Barangay Godofredo Reyes Sr.</h1>
        </div>
        <div>
            <img src="\barangaymanagement\uploads\images\Ragay logo.jpg" alt="Municipality Logo" class="logo-right">
        </div>
    </div>
    <div class="details-container">
        <div class="left-section">
            <div>
                <p class="residentName"><strong>ID Number:</strong> <span id="residentIDDisplay"></span></p>
            </div>
            <div>
                <img class="imageID" id="residentPhoto">
            </div>
        </div>
        <div class="right-section">
            <p class="residentFullName" id="residentFullName"><strong>Full Name:</strong></p>
            <div class="right-section-div1">
                <div>
                    <p class="residentName"><strong>Province:</strong> <span id="residentProvince"></span></p>
                </div>
                <div>
                    <p class="residentName"><strong>Municipality:</strong> <span id="residentMunicipality"></span></p>
                </div>
            </div>
            <div class="right-section-div1">
                <p class="residentName"><strong>Barangay:</strong> <span id="residentBarangay"></span></p>
                <p class="residentName"><strong>Sitio/Zone:</strong> <span id="residentBarangay"></span></p>
            </div>
            <p class="residentName"><strong>Birthdate:</strong> <span id="residentBirthdate"></span></p>
        </div>
    </div>
    <div class="footer-section">
        <div>
            <p class="footer-brgyid-1">Issue Date: <span id="issueDate"><?php echo date('Y-m-d'); ?></span></p>
            <p class="footer-brgyid-1">Expiry Date: <span id="issueDate"><?php echo date('Y-m-d'); ?></span></p>
        </div>
        <div class="footer-brgycaptan">
            <p><span id="issuedBarangay">HON. ESTEBAN H. LACSON JR.</span></p>
            <p><span id="issuedBarangay">Barangay Captain</span></p>
        </div>
    </div>
</div>

<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const photo = document.getElementById('photo');
    const captureButton = document.getElementById('capture');
    const resetButton = document.getElementById('reset');
    const imageDataInput = document.getElementById('imageData');
    const barangayIdContainer = document.getElementById('barangayId');

    // Access the camera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(err => {
            console.error("Error accessing the camera: ", err);
        });

    // Capture the photo
    captureButton.addEventListener('click', () => {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const dataUrl = canvas.toDataURL('image/png');
        photo.src = dataUrl; // Display captured image
        photo.style.display = 'block'; // Show captured image
        imageDataInput.value = dataUrl; // Set image data in hidden input
        barangayIdContainer.style.display = 'block'; // Show Barangay ID container
    });

    // Reset button functionality
    resetButton.addEventListener('click', () => {
        photo.style.display = 'none'; // Hide captured image
        barangayIdContainer.style.display = 'none'; // Hide Barangay ID container
        context.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas
    });

    // Fetch resident details when Resident ID is entered
    document.getElementById('residentID').addEventListener('change', () => {
        const residentID = document.getElementById('residentID').value;

        // Fetch resident details from the server
        fetch(`fetch_resident.php?residentID=${residentID}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error); // Display error if resident not found
                } else {
                    // Populate the fields in the ID container
                    document.getElementById('residentFullName').textContent = `${data.FirstName} ${data.LastName}`;
                    document.getElementById('residentAddress').textContent = data.address;
                    document.getElementById('residentProvince').textContent = data.province;
                    document.getElementById('residentMunicipality').textContent = data.municipality;
                    document.getElementById('residentBarangay').textContent = data.barangay;
                    document.getElementById('residentBirthdate').textContent = data.Birthdate;
                    document.getElementById('residentIDDisplay').textContent = data.ResidentID;
                    document.getElementById('residentPhoto').src = data.PhotoURL || 'default-photo-url.jpg'; // Display resident photo or default image
                }
            })
            .catch(error => {
                console.error('Error fetching resident details:', error);
            });
    });
</script>



</div>

<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\footer.php'; ?>