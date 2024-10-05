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
    $receiptno = $_POST['receiptno'];
    $amount = $_POST['amount'];



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


    // Fetch Punong Barangay's name dynamically from the `barangay_officials` table
    $punongBarangaySql = "SELECT FullName FROM barangay_officials WHERE Position = 'Punong Barangay' LIMIT 1";
    $punongBarangayResult = $conn->query($punongBarangaySql);

    if ($punongBarangayResult->num_rows > 0) {
        $punongBarangayRow = $punongBarangayResult->fetch_assoc();
        $punongBarangayName = $punongBarangayRow['FullName'];  // This will store the Punong Barangay's name
    } else {
        $punongBarangayName = "Punong Barangay Name Not Found";  // Default if not found
    }


    // Fetch pending cases for the resident
    $casesSql = "SELECT caseNo, dateOfFilling, natureOfCase, status FROM cases WHERE residentID = ? AND status = 'pending'";
    $casesStmt = $conn->prepare($casesSql);
    $casesStmt->bind_param("s", $residentId);
    $casesStmt->execute();
    $casesResult = $casesStmt->get_result();

    $casesText = "";
    if ($casesResult->num_rows > 0) {
        $casesText = "The resident has the following pending case(s):\n";
        while ($caseRow = $casesResult->fetch_assoc()) {
            $casesText .= "Case No: " . $caseRow['caseNo'] . ", Date Filed: " . $caseRow['dateOfFilling'] . ", Nature: " . $caseRow['natureOfCase'] . "\n";
        }
    } else {
        $casesText = "<p style='text-align: justify;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that the bearer mentioned above, of legal age, is personally known to the 
        undersigned to be a person of good moral character and law abiding citizen in the 
        community and his/her conduct in the barangay is beyond reproach.</p><br>
        <p style='text-align: justify;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to further certifies that the above 
        mentioned name has no derogatory record in this barangay.</p><br><p style='text-align: justify;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This certification is being issued
        upon the request of the above mentioned person for whaterver legal purpose it may serve.</p>";
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
        // Footer function in your PDF class
        function Footer() {
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('helvetica', 'I', 9);
            // Note in the footer
            $this->Cell(0, 5, 'Note: This is a system-generated certificate with e-signature. Not valid without dry seal and official receipt.', 0, 1, 'C');
            // New line for validity period
            $this->Cell(0, 5, 'Valid only for six months from the date of issue.', 0, 0, 'C');
        }
    }

    // Create new PDF document
    $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Barangay Clearance');

    // Set margins
    $pdf->SetMargins(20, 25, 20); // Increased top margin

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Insert the resident's picture
   // Set initial position for the resident's picture
$imageX = 10; // X-coordinate of the image
$imageY = 45; // Y-coordinate of the image
$imageWidth = 35; // Width of the image
$imageHeight = 30; // Height of the image

// Insert the image if data is available
if ($imageData) {
    $pdf->Image('@' . $imageData, $imageX, $imageY, $imageWidth, $imageHeight, 'JPEG'); 
}

// Adjust text position to prevent overlapping with the image
$textX = $imageX + $imageWidth + 10; // Adds space between the image and text
$textY = $imageY; // Aligns text with the top of the image

// Set position for the text and ensure it does not overlap
$pdf->SetXY($textX, $textY);

// Output each line of resident details separately to avoid overlap
$pdf->MultiCell(0, 3, "Resident ID No: $residentId", 0, 'L', 0, 1);
$pdf->SetXY($textX, $pdf->GetY() + 1);
$pdf->MultiCell(0, 2, "Name: $fullName", 0, 'L', 0, 1);
$pdf->SetXY($textX, $pdf->GetY() + 1); // Adjust Y position for the next line to create spacing
$pdf->MultiCell(0, 2, "Gender: $gender", 0, 'L', 0, 1);
$pdf->SetXY($textX, $pdf->GetY() + 1);
$pdf->MultiCell(0, 2, "Civil Status: $civilStatus", 0, 'L', 0, 1);
$pdf->SetXY($textX, $pdf->GetY() + 1);
$pdf->MultiCell(0, 2, "Age: $age", 0, 'L', 0, 1);
$pdf->SetXY($textX, $pdf->GetY() + 1);
$pdf->MultiCell(0, 2, "Address: $sitioZone, Barangay $barangay, $cityMunicipality, Camarines Sur", 0, 'L', 0, 1);



// Signature (Placeholder)


$pdf->Ln(70);
$pdf->Cell(0, 5, 'Hon. ' . $punongBarangayName . '', 0, 1, 'R');
$pdf->Cell(0, 5, 'Punong Barangay', 0, 1, 'R');


// Date of issuance
$currentDate = date('F j, Y'); // Example format: October 4, 2024

// QR code content (For example: resident details or a URL)
$qrCodeContent = "Resident ID: $residentId\nName: $fullName\nGender: $gender\nCivil Status: $civilStatus\nAge: $age";

// Set X and Y positions for the QR code and Date Issued to display them side by side
$qrCodeX = 15; // X-coordinate for the QR code (left side)
$dateIssuedX = 35; // X-coordinate for the date issuance (right side, adjust as neede


// Add the QR code right after "Doc Stamp: Paid"
$pdf->Ln(5); // Adds some space before the QR code
$pdf->write2DBarcode($qrCodeContent, 'QRCODE,H', 15, $pdf->GetY(), 20, 20);

// Move to the right for the Date Issued section (same Y position)
$pdf->SetXY($dateIssuedX, $pdf->GetY()); // Set the X and keep the same Y

// Output the Date Issued and Doc Stamp on the right

$pdf->MultiCell(0, 5, 'Date Issued: ' . $currentDate, 0, 'L');
$pdf->SetX(35); // Adjust this value for the Doc Stamp as needed
$pdf->MultiCell(0, 5, 'Doc Stamp: Paid', 0, 'L');
$pdf->SetX(35); // Adjust X position to move it to the right
$pdf->MultiCell(0, 5, 'O.R. No.: ' . $receiptno, 0, 'L');
$pdf->SetX(35); // Adjust X position to move it to the right
$pdf->MultiCell(0, 5, 'Amount: ' . $amount, 0, 'L');

 

    // Add the cases information or clearance statement
    $pdf->SetXY(15, $imageY + $imageHeight + 20); // Position below the image and details
    $pdf->MultiCell(0, 12, $casesText, 0, 'L', 0, 1, '', '', true, 0, true);



    // Output the PDF
    $pdf->Output('barangay_clearance.pdf', 'I');
}
?>