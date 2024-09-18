<?php
// Include your database connection
include 'D:\GrsDatabase\htdocs\barangaymanagement\app\config\db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $residentID = $_POST['residentID'];
    $fullName = $_POST['full_name'];
    $address = $_POST['address'];
    $purpose = $_POST['purpose'];
    $pictureData = $_POST['picture']; // The base64-encoded image data
    
    // Decode base64 image data
    list($type, $pictureData) = explode(';', $pictureData);
    list(, $pictureData)      = explode(',', $pictureData);
    $pictureData = base64_decode($pictureData);
    
    // Generate a filename for the picture
    $pictureFilename = 'uploads/pictures/' . uniqid() . '.png';
    
    // Save the decoded image data to the server
    file_put_contents($pictureFilename, $pictureData);

    // Generate QR code with resident's details
    $qrText = "Name: $fullName, Address: $address, Purpose: $purpose, Issued: " . date('Y-m-d');
    $qrCode = new QrCode($qrText);
    $qrCode->setSize(150);
    
    // Save the QR code as an image
    $qrCodeWriter = new PngWriter();
    $qrCodeFile = 'uploads/qrcodes/' . uniqid() . '.png';
    $qrCodeWriter->writeFile($qrCode, $qrCodeFile);
    
    // Insert the clearance details into the database
    $sql = "INSERT INTO barangay_clearances (ResidentID, FullName, Address, Purpose, DateIssued, Picture, QRCode)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $dateIssued = date('Y-m-d');
    $stmt->bind_param("issssss", $residentID, $fullName, $address, $purpose, $dateIssued, $pictureFilename, $qrCodeFile);
    
    if ($stmt->execute()) {
        echo "Barangay Clearance generated successfully.";
    } else {
        echo "Error generating clearance: " . $db->error;
    }
}
?>
