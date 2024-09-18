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
            $this->Image($leftLogo, 40, 15, 25); // X, Y, Width (adjust as needed)

            // Insert right logo
            $this->Image($rightLogo, 145, 15, 22); // X, Y, Width (adjust as needed)

            // Set font for the titles
            $this->SetFont('helvetica', 'B', 14);
            $this->SetY(15); // Adjust the value to your desired margin

            // Main title centered between the logos
            $this->Cell(0, 5, 'Province of Camarines Sur', 0, 1, 'C');
            $this->Cell(0, 5, 'Municipality of Ragay', 0, 1, 'C');
            $this->Cell(0, 5, 'Barangay Godofredo Reyes Sr.', 0, 1, 'C');

            // Add the second title: Office of the Barangay Captain
            $this->SetFont('helvetica', '', 12); // Slightly smaller font for the second title
            $this->Cell(0, 5, 'Office of the Barangay Captain', 0, 1, 'C');

            // Set Y position for the line under the header and draw it
            $this->SetY(35);
            $this->SetLineWidth(0.3); // Line thickness
            $this->Line(10, 40, 200, 40); // X1, Y1, X2, Y2
        }
    }

    // Create new PDF document
    $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Barangay Clearance');

    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, 60, PDF_MARGIN_RIGHT); // Increased top margin

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Insert the resident's picture
    $imageX = 15; // X-coordinate of the image
    $imageY = 50; // Y-coordinate of the image
    $imageWidth = 40; // Width of the image
    $imageHeight = 40; // Height of the image

    if ($imageData) {
        $pdf->Image('@' . $imageData, $imageX, $imageY, $imageWidth, $imageHeight, 'JPEG'); // Adjust position and size accordingly
    }

    // Create Barangay Clearance content
    $textX = $imageX + $imageWidth + 10; // 10 units space between image and text
    $textY = $imageY; // Align with the top of the image

    $pdf->SetXY($textX, $textY);
    
    $pdf->SetFont('helvetica', '', 12);
    $pdf->MultiCell(0, 12, "
    <p><strong>Name:</strong> $fullName</p>
    <p><strong>Gender:</strong> $gender</p>
    <p><strong>Civil Status:</strong> $civilStatus</p>
    <p><strong>Age:</strong> $age</p>
    <p><strong>Address:</strong> $sitioZone, Barangay $barangay, $cityMunicipality, Camarines Sur</p>", 0, 'L', 0, 1, '', '', true, 0, true
    );


    $pdf->SetFont('helvetica', '', 12);
    $pdf->MultiCell(0, 12, "
   
    <p>This is to certify that the name above-mentioned name ha no derogatory record in this barangay.</p>", 0, 'L', 0, 1, '', '', true, 0, true
    );




    // Output the PDF
    $pdf->Output('barangay_clearance.pdf', 'I');
}
?>
