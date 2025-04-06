<?php
// Set headers to prevent download and allow only inline viewing
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="sample.pdf"');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

// Specify the path to your PDF file
$filePath = 'terms&conditions.pdf';

// Check if the file exists
if (file_exists($filePath)) {
    // Output the PDF file
    readfile($filePath);
} else {
    // Show an error message if the file doesn't exist
    echo "The requested file does not exist.";
}
?>
