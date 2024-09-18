<?php

require __DIR__ . 'D:\GrsDatabase\htdocs\barangaymanagement\vendor\autoload.php'; // Include the Composer autoload file

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\Writer\PngWriter;

// Generate the QR Code
$qrCode = Builder::create()
    ->writer(new PngWriter())  // Use the PNG writer
    ->data('https://example.com')  // The data to encode in the QR code (URL, text, etc.)
    ->encoding(new Encoding('UTF-8'))
    ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
    ->size(300)  // Size of the QR code
    ->margin(10) // Margin around the QR code
    ->labelText('Scan Me') // Optional label
    ->labelFont(new NotoSans(20))  // Label font
    ->labelAlignment(new LabelAlignmentCenter())
    ->build(); // Build the QR code

// Define the file path to save the QR code image
$qrCodeImagePath = __DIR__ . '/qrcode.png';

// Save the QR code to a file
$qrCode->saveToFile($qrCodeImagePath);

// Force download the image as a file
header('Content-Type: image/png');
header('Content-Disposition: attachment; filename="qrcode.png"');
header('Content-Length: ' . filesize($qrCodeImagePath));

// Output the file to the browser for download
readfile($qrCodeImagePath);



<?php
require_once('D:\GrsDatabase\htdocs\barangaymanagement\vendor\tecnickcom\tcpdf\tcpdf.php');
// Database connection details
$host = 'localhost';
$db = 'barangay_management_system';
$user = 'root';
$pass = '';

// Establish connection
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $residentId = $_POST['residentId'];

    // Fetch resident data from the database
    $sql = "SELECT FirstName, MiddleName, LastName, Gender, CivilStatus, Birthdate, BirthPlace, Occupation, Citizenship, CityMunicipality, Barangay, SitioZone FROM residents WHERE ResidentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $residentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fullName = $row['FirstName'] . ' ' . $row['MiddleName'] . ' ' . $row['LastName'];
        $gender = $row['Gender'];
        $civilStatus = $row['CivilStatus'];
        $birthdate = $row['Birthdate'];
        $birthPlace = $row['BirthPlace'];
        $occupation = $row['Occupation'];
        $citizenship = $row['Citizenship'];
        $cityMunicipality = $row['CityMunicipality'];
        $barangay = $row['Barangay'];
        $sitioZone = $row['SitioZone'];

        // Calculate age
        $birthDateTime = new DateTime($birthdate);
        $today = new DateTime();
        $age = $today->diff($birthDateTime)->y;
    } else {
        echo "No resident found with ID $residentId";
        exit;
    }

    // Get captured image from the form
    $imageDataURL = $_POST['capturedImage'];
    $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageDataURL));

    // Generate Barangay Clearance PDF using TCPDF
    class PDF extends TCPDF {
        public function Header() {
            // Path to logos
            $leftLogo = 'D:\GrsDatabase\htdocs\barangaymanagement\uploads\images\grslogo.jpg';  // Replace with actual path
            $rightLogo = 'D:\GrsDatabase\htdocs\barangaymanagement\uploads\images\Ragay logo.jpg'; // Replace with actual path

            // Insert left logo
            $this->Image($leftLogo, 40, 9, 22); // X, Y, Width (adjust as needed)

            // Insert right logo
            $this->Image($rightLogo, 150, 9, 20); // X, Y, Width (adjust as needed)

            // Set font for the titles
            $this->SetFont('helvetica', 'B', 14);

            $this->SetY(10); // Adjust the value to your desired margin

            // Main title centered between the logos
            $this->Cell(0, 5, 'Province of Camarines Sur', 0, 5, 'C');
            $this->Cell(0, 5, 'Municipality of Ragay', 0, 1, 'C');
            $this->Cell(0, 5, 'Barangay Godofredo Reyes Sr.', 0, 1, 'C');

            // Add the second title: Office of the Barangay Captain
            $this->SetFont('helvetica', '', 12); // Slightly smaller font for the second title
            $this->Cell(0, 5, 'Office of the Barangay Captain', 0, 1, 'C');

            // Set Y position for the line under the header and draw it
            $this->SetY(30);
            $this->SetLineWidth(0.3); // Line thickness
            $this->Line(15, 35, 190, 35); // X1, Y1, X2, Y2
        }
    }

    // Create new PDF document
    $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setTitle('');
    
    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    if ($imageData) {
        $pdf->Image('@' . $imageData, 15, 40, 40, 40, 'JPEG'); // Adjust position and size accordingly
    }

    // Create Barangay Clearance content
   
    // Move to the right of the image
    $pdf->SetXY(55, 40); // Adjust X and Y to position the text content to the right of the image

    // Create Barangay Clearance content
    $html = "
    <p><strong>Name:</strong> $fullName</p>
    <p><strong>Gender:</strong> $gender</p>
    <p><strong>Civil Status:</strong> $civilStatus</p>
    <p><strong>Age:</strong> " . date_diff(date_create($birthdate), date_create('today'))->y . "</p>
    <p><strong>Address:</strong> $sitioZone, Barangay $barangay, $cityMunicipality, Camarines Sur</p>";

    // Output the content
    $pdf->writeHTML($html, true, false, true, false, '');


   
    // Output the PDF
    $pdf->Output('barangay_clearance.pdf', 'I');
}
?>
