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
