<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Clearance Form</title>
    <style>
        #video {
            width: 320px;
            height: 240px;
            border: 1px solid black;
        }

        #canvas {
            display: none;
        }

        #photo {
            width: 320px;
            height: 240px;
        }
    </style>
</head>
<body>
    <h1>Barangay Clearance Form</h1>

    <form method="POST" action="process_clearance.php">
        <label for="residentID">Resident ID:</label>
        <input type="text" name="residentID" id="residentID" required>
        
        <label for="purpose">Purpose:</label>
        <input type="text" name="purpose" id="purpose" required>
        
        <input type="submit" value="Generate Clearance">
    </form>



    <script>
        // Camera logic to capture the image
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const photo = document.getElementById('photo');
        const imageDataInput = document.getElementById('imageData');

        // Get access to the user's camera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                console.error("Error accessing camera: ", err);
            });

        // Capture the image when the button is clicked
        document.getElementById('capture').addEventListener('click', function() {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageDataURL = canvas.toDataURL('image/png');
            photo.src = imageDataURL;
            imageDataInput.value = imageDataURL;
        });
    </script>
</body>
</html>
