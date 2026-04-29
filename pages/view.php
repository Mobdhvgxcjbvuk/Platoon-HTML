<?php
if (!isset($_GET['file'])) {
    http_response_code(400);
    die('No file specified');
}

$filename = basename($_GET['file']);
$filepath = UPLOAD_PATH . '/' . $filename;

// Security check
if (!file_exists($filepath) || !preg_match('/\.html$/i', $filename)) {
    http_response_code(404);
    die('File not found');
}

// Serve the HTML file with proper headers
header('Content-Type: text/html; charset=utf-8');
readfile($filepath);
?>
