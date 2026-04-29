<?php
/**
 * Platoon HTML Server
 * A deployable PHP web application for serving HTML files
 */

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

define('BASE_PATH', __DIR__);
define('PUBLIC_PATH', BASE_PATH . '/public');
define('UPLOAD_PATH', BASE_PATH . '/uploads');

// Create uploads directory if it doesn't exist
if (!is_dir(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH, 0755, true);
}

// Simple router
$request = $_SERVER['REQUEST_URI'];
$request = parse_url($request, PHP_URL_PATH);
$request = str_replace('/index.php', '', $request);
$request = ltrim($request, '/');

// Route handling
if (empty($request) || $request === '') {
    include 'pages/home.php';
} elseif ($request === 'api/upload') {
    include 'api/upload.php';
} elseif ($request === 'api/list') {
    include 'api/list.php';
} elseif (preg_match('/^view\/(.+)$/', $request, $matches)) {
    $_GET['file'] = $matches[1];
    include 'pages/view.php';
} else {
    http_response_code(404);
    include 'pages/404.php';
}
?>
