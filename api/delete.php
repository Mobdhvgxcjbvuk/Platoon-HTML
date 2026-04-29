<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['file'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No file specified']);
    exit;
}

$filename = basename($data['file']);
$filepath = UPLOAD_PATH . '/' . $filename;

// Security check
if (!file_exists($filepath) || !preg_match('/\.html$/i', $filename)) {
    http_response_code(404);
    echo json_encode(['error' => 'File not found']);
    exit;
}

if (unlink($filepath)) {
    echo json_encode(['success' => true, 'message' => 'File deleted successfully']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to delete file']);
}
?>
