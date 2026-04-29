<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isset($_FILES['file'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No file provided']);
    exit;
}

$file = $_FILES['file'];
$filename = basename($file['name']);
$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

// Validate file
if ($ext !== 'html') {
    http_response_code(400);
    echo json_encode(['error' => 'Only HTML files are allowed']);
    exit;
}

if ($file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'Upload failed']);
    exit;
}

if ($file['size'] > 10 * 1024 * 1024) { // 10MB limit
    http_response_code(413);
    echo json_encode(['error' => 'File too large (max 10MB)']);
    exit;
}

// Generate unique filename
$unique_filename = date('Y-m-d_H-i-s_') . uniqid() . '.html';
$destination = UPLOAD_PATH . '/' . $unique_filename;

if (move_uploaded_file($file['tmp_name'], $destination)) {
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'File uploaded successfully',
        'filename' => $unique_filename
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save file']);
}
?>
