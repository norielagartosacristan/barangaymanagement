<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\header.php'; ?>

<div class="main">

    <style>
        #video {
    width: 205px;
    height: 154px;
    border: 1px solid black;
    margin-top: 5px;
}

#canvas {
    display: none;
    /* Hide the canvas until capturing */
}

#photo {
    display: none;
    /* Hide photo until captured */
    width: 205px;
    height: 154px;
    border: 1px solid black;
    margin-top: 10px;
}

.id-container {
    width: 340px;
    height: 210px;
    border: 2px solid #000;
    border-radius: 10px;
    background-color: #f9f9f9;
    padding: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    position: relative;
    display: none;
    /* Initially hidden until photo is taken */
    margin-top: 20px;
}

.signature-pad {
    border: 1px solid #000;
    margin-top: 5px;
}

button {
    margin-top: 5px;
}
.logo-left {
    width: 50px;
    height: 50px;
}
.logo-right {
    width: 50px;
    height: 50px;
    float: right;
}
.header-brgyid {
    font-size: 12px;
    text-align: center;
    line-height: 8px;
}
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
#residentPhoto {
    width: 60px;
    height: 60px;
}
.rightdetails {
    font-size: 11px;
}


.details-container {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    gap: 30px;
}
.rightdiv {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    align-items: center;
}
    </style>

    <h2>Generate Barangay ID</h2>

    <form id="idForm">
        <label for="residentID">Resident ID:</label>
        <input type="text" id="residentID" name="residentID" required>
        <br><br>

        <!-- Video stream for camera capture -->
        <video id="video" autoplay></video>
        <br>
        <button type="button" id="capture">Capture Photo</button>
        <canvas id="canvas" width="320" height="240"></canvas>
        <br>
        <img id="photo" alt="Captured Photo">
        <br><br>

        <!-- Signature pad -->
        <canvas id="signaturePad" class="signature-pad" width="320" height="100"></canvas>
        <br>
        <button type="button" id="clearSignature">Clear Signature</button>
        <br><br>

        <button type="button" id="generateID">Generate ID</button>
        <button type="button" id="resetForm">Reset</button>
    </form>

    <!-- Container for displaying generated Barangay ID -->
    <div class="id-container" id="barangayId">
        <div class="header-section">
            <div>
                <img src="\barangaymanagement\uploads\images\grslogo.jpg" alt="Barangay Logo" class="logo-left">
            </div>
            <div>
                <h1 class="header-brgyid" id="barangayName">Province of Camarines Sur</h1>
                <h1 class="header-brgyid" id="barangayName">Municipality of Ragay</h1>
                <h2 class="header-brgyid" id="municipalityName">Barangay Godofredo Reyes Sr.</h2>
            </div>
            <div>
                <img src="\barangaymanagement\uploads\images\Ragay logo.jpg" alt="Municipality Logo" class="logo-right">
            </div>
        </div>
        <div class="details-container">
            <div class="left-section">
                <img id="residentPhoto" alt="Profile Picture">
            </div>
            <div class="right-section">
                <div class="rigthdiv">
                    <div>
                        <h2><strong>Name:</strong> <span id="residentFullName"></span></h2>
                    </div>
                    <div>
                        <p><strong>Birthdate:</strong> <span id="residentBirthdate"></span></p>
                    </div>
                </div>
                <div class="rigthdiv">
                    <p><strong>Province:</strong> <span id="residentProvince"></span></p>
                    <p><strong>Municipality:</strong> <span id="residentMunicipality"></span></p>
                </div>
                <div class="rigthdiv">
                    <p><strong>Barangay:</strong> <span id="residentBarangay"></span></p>
                    <p><strong>Sito/Zone:</strong> <span id="residentSitio"></span></p>
                </div>
                <p><strong>ID Number:</strong> <span id="residentIDDisplay"></span></p>
                <p><strong>Signature:</strong> <img id="signatureImage" alt="Signature"></p>
            </div>
        </div>
        <div class="footer-section">
            <p>Issued by Barangay <span id="issuedBarangay">Godofredo Reyes Sr.</span></p>
            <p>Issue Date: <span id="issueDate"></span></p>
            <button type="button" id="printID">Print ID</button>
        </div>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        const photo = document.getElementById('photo');
        const captureButton = document.getElementById('capture');
        const resetButton = document.getElementById('resetForm');
        const generateIDButton = document.getElementById('generateID');
        const signaturePad = document.getElementById('signaturePad');
        const signatureContext = signaturePad.getContext('2d');
        const clearSignatureButton = document.getElementById('clearSignature');
        const idContainer = document.getElementById('barangayId');
        const printIDButton = document.getElementById('printID');

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
            photo.style.display = 'block'; // Show captured photo

            // Set captured image in ID
            const residentPhoto = document.getElementById('residentPhoto');
            residentPhoto.src = dataUrl; // Display captured image on the ID
            residentPhoto.style.display = 'block'; // Show the resident photo on the ID
        });

        // Reset form functionality
        resetButton.addEventListener('click', () => {
            document.getElementById('idForm').reset();
            photo.style.display = 'none'; // Hide captured photo
            context.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas
            signatureContext.clearRect(0, 0, signaturePad.width, signaturePad.height); // Clear signature
            idContainer.style.display = 'none'; // Hide ID container
        });

        // Clear the signature pad
        clearSignatureButton.addEventListener('click', () => {
            signatureContext.clearRect(0, 0, signaturePad.width, signaturePad.height);
        });

        // Fetch resident details from the server and generate Barangay ID
        generateIDButton.addEventListener('click', () => {
            const residentID = document.getElementById('residentID').value;

            // Fetch resident details from the server
            fetch('D:\GrsDatabase\htdocs\barangaymanagement\app\views\BarangayID\fetch_resident.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ residentID })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Populate the ID details
                        document.getElementById('residentFullName').textContent = `${data.resident.firstName} ${data.resident.middleName} ${data.resident.lastName}`;
                        document.getElementById('residentProvince').textContent = data.resident.province;
                        document.getElementById('residentMunicipality').textContent = data.resident.cityMunicipality;
                        document.getElementById('residentBarangay').textContent = data.resident.barangay;
                        document.getElementById('residentSitio').textContent = data.resident.sitioZone;
                        document.getElementById('residentBirthdate').textContent = data.resident.birthdate;
                        document.getElementById('residentIDDisplay').textContent = data.resident.residentID;

                        // Display the ID container
                        idContainer.style.display = 'block';
                        printIDButton.style.display = 'block'; // Show print button

                        // Insert the current date as the issue date
                        document.getElementById('issueDate').textContent = new Date().toLocaleDateString();

                        // Display the signature
                        const signatureDataUrl = signaturePad.toDataURL('image/png');
                        document.getElementById('signatureImage').src = signatureDataUrl;
                    } else {
                        alert('Resident not found. Please check the Resident ID.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching resident details:', error);
                    alert('An error occurred while fetching resident details.');
                });
        });

        // Print the ID
        printIDButton.addEventListener('click', () => {
            const printContents = idContainer.innerHTML;
            const originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            window.location.reload(); // Refresh page to restore original state
        });
    </script>
</div>
   
<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\footer.php'; ?>