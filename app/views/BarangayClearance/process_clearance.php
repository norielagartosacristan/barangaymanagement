<?php
require_once('D:\GrsDatabase\htdocs\barangaymanagement\vendor\autoload.php');  // Include TCPDF via Composer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $db = new mysqli('localhost', 'root', '', 'barangay_management_system');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Get the Resident ID and purpose
    $residentID = $_POST['residentID'];
    $purpose = $_POST['purpose'];

    // Fetch the resident details from the 'resident' table using the Resident ID
    $stmt = $db->prepare("SELECT firstName, middleName, lastName, photo FROM residents WHERE residentID = ?");
    $stmt->bind_param("s", $residentID);
    $stmt->execute();
    $stmt->bind_result($firstName, $middleName, $lastName, $photo);
    
    if ($stmt->fetch()) {
        // If resident found, continue to generate clearance
        $photoPath = $photo ? 'uploads/pictures' . $photo : '';  // Ensure photo path is correct
        generateBarangayClearancePDF($residentID, $firstName, $middleName, $lastName, $purpose, $photoPath);
    } else {
        // Resident not found
        echo "Resident not found!";
    }

    $stmt->close();
    $db->close();
}

// Function to generate PDF for Barangay Clearance
function generateBarangayClearancePDF($residentID, $firstName, $middleName, $lastName, $purpose, $photoPath) {
    // Create new PDF document
    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator('Barangay System');
    $pdf->SetTitle('Barangay Clearance');
    
    // Add a page
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Barangay Header (Customizable)
    $pdf->Cell(0, 10, 'Republic of the Philippines', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Province of YourProvince', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Barangay Name', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Barangay Clearance', 0, 1, 'C');

    // Resident Information
    $pdf->Ln(10);  // Add line break
    $pdf->Cell(0, 10, 'Resident ID: ' . $residentID, 0, 1);
    $pdf->Cell(0, 10, 'Name: ' . $firstName . ' ' . $middleName . ' ' . $lastName, 0, 1);  // Include full name with middle name
    $pdf->Cell(0, 10, 'Purpose: ' . $purpose, 0, 1);

    // Add photo of the resident if exists
    if (file_exists($photoPath)) {
        $pdf->Image($photoPath, 15, 60, 40, 40); // Adjust the image position and size
    }

    // Generate and Add QR Code
    $qrCode = new \Endroid\QrCode\QrCode('Resident ID: ' . $residentID);
    $qrCodePath = 'uploads/qrcode_' . $residentID . '.png';
    $qrCode->writeFile($qrCodePath);  // Save QR code

    if (file_exists($qrCodePath)) {
        $pdf->Image($qrCodePath, 160, 60, 40, 40);  // Position QR code on the PDF
    }

    // Signature (Placeholder)
    $pdf->Ln(70);
    $pdf->Cell(0, 10, '__________________________', 0, 1, 'R');
    $pdf->Cell(0, 10, 'Barangay Captain', 0, 1, 'R');

    // Output the PDF as a file download
    $pdf->Output('barangay_clearance_' . $residentID . '.pdf', 'D');
}
?>