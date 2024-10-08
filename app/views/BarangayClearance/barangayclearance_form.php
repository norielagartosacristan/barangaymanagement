<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\header.php'; ?>

    <script>
        // Start the camera when the page loads
        function startCamera() {
            const video = document.querySelector('video');
            navigator.mediaDevices.getUserMedia({ video: true })
                .then((stream) => {
                    video.srcObject = stream;
                })
                .catch((err) => {
                    console.error("Error accessing the camera: ", err);
                    alert("Unable to access camera. Please check browser permissions.");
                });
        }

        // Capture the image from the video stream
        function captureImage() {
            const video = document.querySelector('video');
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            // Draw the image from the video onto the canvas
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Convert canvas to data URL (base64)
            const imageDataURL = canvas.toDataURL('image/jpeg'); // You can use 'image/png' or 'image/jpeg'

            // Set the image data in the hidden input field
            document.getElementById('capturedImage').value = imageDataURL;

            // Show the captured image preview
            const preview = document.getElementById('imagePreview');
            preview.src = imageDataURL;
            preview.style.display = 'block'; // Display the image preview
        }

        // Reset the image capture
        function resetCapture() {
            const video = document.querySelector('video');
            const preview = document.getElementById('imagePreview');
            
            // Clear the hidden input field
            document.getElementById('capturedImage').value = '';

            // Hide the image preview
            preview.style.display = 'none';

            // Optionally, restart the camera stream
            video.srcObject = null;
            startCamera();
        }
    </script>



<div class="wrapper-bclearance">
<div>
<h1 class="bc-clearance-h1">Barangay Clearance Form</h1>
    <form action="generate_clearance.php" method="POST" enctype="multipart/form-data">
        <!-- Resident ID Input -->
         <div class="form-group">
         <div>
                <label for="residentId">Resident ID:</label>
                <input type="text" id="residentId" name="residentId" required>
            </div>
            <div>
                <label for="residentId">Official Receipt No.:</label>
                <input type="text" id="receiptno" name="receiptno" required>
            </div>
            <div>
                 <label for="amount">Amount:</label>
                 <input type="text" id="amount" name="amount" required>
            </div>
            
         </div>
           
            <!-- Video Stream for Capture -->
            <div>
                <h3>Capture Photo</h3>
                <video id="video" autoplay></video>
                <br>
                <button class="btn btn-primary" type="button" onclick="captureImage()">Capture Image</button>
                <button class="btn btn-info" type="button" onclick="resetCapture()">Reset</button>

                <!-- Hidden Input to Store Captured Image Data -->
                <input type="hidden" id="capturedImage" name="capturedImage">
                
                <!-- Image Preview -->
                <img id="imagePreview" alt="Captured Image Preview">
            </div>

            <!-- Submit Button -->
            <br>
            <button class="btn btn-success" type="submit">Generate Clearance</button>
    </form>
</div>

</div>

<?php include 'D:\GrsDatabase\htdocs\barangaymanagement\app\views\footer.php'; ?>