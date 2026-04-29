document.addEventListener('DOMContentLoaded', function() {
    const uploadForm = document.getElementById('uploadForm');
    const uploadStatus = document.getElementById('uploadStatus');

    if (uploadForm) {
        uploadForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const fileInput = document.getElementById('fileInput');
            const file = fileInput.files[0];

            if (!file) {
                showStatus('Please select a file', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('file', file);

            try {
                const response = await fetch('api/upload', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    showStatus('✓ File uploaded successfully! Refreshing...', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showStatus('✗ ' + (data.error || 'Upload failed'), 'error');
                }
            } catch (error) {
                showStatus('✗ Error: ' + error.message, 'error');
            }
        });
    }
});

function showStatus(message, type) {
    const status = document.getElementById('uploadStatus');
    status.textContent = message;
    status.className = type;
}

function deleteFile(filename) {
    if (confirm('Are you sure you want to delete this file?')) {
        fetch('api/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ file: filename })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting file: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(err => alert('Error: ' + err.message));
    }
}
