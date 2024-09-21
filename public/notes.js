
// Check if the signature pad has been drawn on
function isSignatureDrawn() {
    const signatureData = signaturePad.toDataURL();
    return signatureData !== signaturePad.toDataURL('image/png'); // Check if the signature pad is blank
}

// Disable Generate ID button initially
generateIDButton.disabled = true;

// Enable Generate ID button only when a signature is drawn
signaturePad.addEventListener('mouseup', () => {
    if (isSignatureDrawn()) {
        generateIDButton.disabled = false;
    }
});

// Generate Barangay ID with resident details and signature
generateIDButton.addEventListener('click', () => {
    if (!isSignatureDrawn()) {
        alert('Please sign before generating the ID.');
        return;
    }

    const residentID = document.getElementById('residentID').value;

    // Fetch resident details from the server
    fetch(`fetch_resident_details.php?residentID=${residentID}`)
        .then(response => response.json())
        .then(data => {
            // Display resident details in the ID if found
            if (data.success) {
                document.getElementById('residentFullName').textContent = data.fullName;
                document.getElementById('residentAddress').textContent = data.address;
                document.getElementById('residentProvince').textContent = data.province;
                document.getElementById('residentMunicipality').textContent = data.municipality;
                document.getElementById('residentBarangay').textContent = data.barangay;
                document.getElementById('residentBirthdate').textContent = data.birthdate;
                document.getElementById('residentIDDisplay').textContent = residentID;

                // Show the ID container
                idContainer.style.display = 'block';
                printIDButton.style.display = 'block'; // Show print button

                // Display the signature
                const signatureDataUrl = signaturePad.toDataURL('image/png');
                document.getElementById('signatureImage').src = signatureDataUrl;

                // Set issue date
                const today = new Date().toLocaleDateString();
                document.getElementById('issueDate').textContent = today;
            } else {
                alert('Resident not found. Please check the Resident ID.');
            }
        })
        .catch(error => {
            console.error('Error fetching resident details:', error);
            alert('Error fetching resident details. Please try again.');
        });
});

