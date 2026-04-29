<?php
header('Content-Type: application/json');

$files = array_diff(scandir(UPLOAD_PATH), ['.', '..']);
$files = array_filter($files, function($f) {
    return strtolower(pathinfo($f, PATHINFO_EXTENSION)) === 'html';
});

$fileList = array_map(function($f) {
    $filepath = UPLOAD_PATH . '/' . $f;
    return [
        'name' => $f,
        'size' => filesize($filepath),
        'modified' => date('Y-m-d H:i:s', filemtime($filepath)),
        'url' => '/view/' . urlencode($f)
    ];
}, array_values($files));

echo json_encode(['files' => $fileList]);
?>
