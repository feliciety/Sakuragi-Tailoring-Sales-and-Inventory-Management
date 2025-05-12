<?php
require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../../config/session_handler.php';
?>

<h5 class="mb-3 fw-bold text-center">Step 2: Upload Your Design File</h5>
<p class="text-muted text-center">
    Upload your final design layout. <strong>Only PSD and ZIP files</strong> are accepted for accurate processing.
</p>

<!-- Order Summary Section -->
<div id="orderSummary" class="mb-4"></div>

<!-- Upload Section -->
<div class="card">
    <div class="card-body">
        <div class="upload-drop-area" id="uploadDropArea">
            <input type="file" class="d-none" id="image" accept=".psd,.zip" onchange="handleFileUpload(this)">
            <label for="image" class="text-center w-100 mb-0" style="cursor: pointer;">
                <div class="upload-icon mb-3">📁</div>
                <h6 class="upload-text mb-2">Drop your file here or click to browse</h6>
                <p class="text-muted small mb-0">Maximum file size: 10MB<br>Accepted formats: .PSD, .ZIP</p>
            </label>
        </div>

        <!-- File Info Container -->
        <div id="fileInfoContainer" class="d-none mt-4">
            <!-- File info will be populated here -->
        </div>

        <!-- Preview Container -->
        <div id="imagePreviewContainer" class="text-center mt-4 d-none">
            <div class="preview-wrapper">
                <img id="imagePreview" class="img-fluid rounded" alt="Design preview">
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm mt-3" onclick="removeUploadedFile()">
                Remove File
            </button>
        </div>
    </div>
</div>

<script>
// Handle file upload and preview
function handleFileUpload(input) {
    const file = input.files[0];
    if (!file) return;

    // Validate file type
    const allowedTypes = ['image/vnd.adobe.photoshop', 'application/zip'];
    if (!allowedTypes.includes(file.type)) {
        alert('Invalid file type. Only PSD and ZIP files are allowed.');
        input.value = '';
        return;
    }

    // Validate file size (10MB)
    if (file.size > 10 * 1024 * 1024) {
        alert('File size exceeds the maximum limit of 10MB.');
        input.value = '';
        return;
    }

    // Update order data with file information
    const designData = {
        fileName: file.name,
        fileSize: file.size,
        fileType: file.type,
        uploadDate: new Date().toISOString()
    };

    // Update order data
    updateOrderData({ design: designData });

    // Show file info
    document.getElementById('fileInfoContainer').innerHTML = `
        <div class="alert alert-info">
            <p class="mb-2"><strong>Selected file:</strong> ${file.name}</p>
            <p class="mb-0"><strong>Size:</strong> ${(file.size / 1024 / 1024).toFixed(2)} MB</p>
        </div>
    `;
    document.getElementById('fileInfoContainer').classList.remove('d-none');

    // Handle preview if it's an image
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            preview.src = e.target.result;
            document.getElementById('imagePreviewContainer').classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('imagePreviewContainer').classList.add('d-none');
    }
}

// Remove uploaded file
function removeUploadedFile() {
    const fileInput = document.getElementById('image');
    const fileInfoContainer = document.getElementById('fileInfoContainer');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');

    fileInput.value = '';
    fileInfoContainer.innerHTML = '';
    fileInfoContainer.classList.add('d-none');
    imagePreviewContainer.classList.add('d-none');

    // Clear design data from order
    updateOrderData({ design: null });
}

// Initialize drag and drop
document.addEventListener('DOMContentLoaded', function() {
    const dropArea = document.getElementById('uploadDropArea');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropArea.classList.add('highlight');
    }

    function unhighlight(e) {
        dropArea.classList.remove('highlight');
    }

    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        document.getElementById('image').files = files;
        handleFileUpload(document.getElementById('image'));
    }
});
</script>

<style>
.upload-drop-area {
    border: 3px dashed #ccc;
    border-radius: 16px;
    padding: 50px 20px;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
}

.upload-drop-area.highlight {
    border-color: #0B5CF9;
    background-color: #e8f0ff;
}

.upload-icon {
    font-size: 48px;
    color: #0B5CF9;
    transition: transform 0.3s ease;
}

.upload-drop-area:hover {
    border-color: #0B5CF9;
    background-color: #f1f1ff;
}

.upload-drop-area:hover .upload-icon {
    transform: scale(1.1);
}

.preview-wrapper {
    max-width: 300px;
    margin: 0 auto;
}

#imagePreview {
    max-height: 200px;
    object-fit: contain;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    padding: 8px;
}

.alert {
    border-radius: 8px;
}
</style>
