<?php
$file = 'success_ibps.pdf'; // Replace with your PDF file path

if (file_exists($file)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Content-Length: ' . filesize($file));
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    
    // Read the file and output it to the browser
    readfile($file);
    exit;
} else {
    echo "File does not exist.";
}
?>
