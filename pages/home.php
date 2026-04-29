<?php
$files = array_diff(scandir(UPLOAD_PATH), ['.', '..']);
$files = array_filter($files, function($f) {
    return strtolower(pathinfo($f, PATHINFO_EXTENSION)) === 'html';
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platoon HTML Server</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>🚀 Platoon HTML Server</h1>
        <p>Upload and serve HTML files easily</p>
    </header>

    <main class="container">
        <section class="upload-section">
            <h2>Upload HTML File</h2>
            <form id="uploadForm" enctype="multipart/form-data">
                <div class="file-input-wrapper">
                    <input type="file" id="fileInput" name="file" accept=".html" required />
                    <label for="fileInput">Choose HTML file</label>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
            <div id="uploadStatus"></div>
        </section>

        <section class="files-section">
            <h2>Available HTML Files</h2>
            <?php if (!empty($files)): ?>
                <div class="files-list">
                    <?php foreach ($files as $file): ?>
                        <div class="file-item">
                            <span class="file-name">📄 <?php echo htmlspecialchars($file); ?></span>
                            <div class="file-actions">
                                <a href="view/<?php echo urlencode($file); ?>" class="btn btn-info" target="_blank">View</a>
                                <button class="btn btn-danger" onclick="deleteFile('<?php echo htmlspecialchars($file); ?>')">Delete</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-files">No HTML files uploaded yet. Upload one to get started!</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Platoon HTML Server | Deployable PHP Application</p>
    </footer>

    <script src="assets/script.js"></script>
</body>
</html>
