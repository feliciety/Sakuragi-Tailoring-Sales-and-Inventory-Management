<?php
require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../../config/session_handler.php';
?>

<h5 class="mb-3 fw-bold text-center">Step 2: Upload Your Design File</h5>
<p class="text-muted text-center">
    Upload your final design layout. <strong>Only PSD and ZIP files</strong> are accepted for accurate processing.
</p>
<p class="text-info text-center small">
    <i class="fas fa-info-circle"></i> You'll see a progress bar while your file uploads. Once completed, file details will be displayed below.
</p>

<!-- Order Summary Section -->
<div id="orderSummary" class="mb-4"></div>

<!-- Upload Section -->
<div class="card">
    <div class="card-body">
        <div class="upload-drop-area" id="uploadDropArea">
            <input type="file" class="d-none" id="image" accept=".psd,.zip" onchange="handleFileUpload()">
            <label for="image" class="text-center w-100 mb-0" style="cursor: pointer;">
                <div class="upload-icon mb-3">📁</div>
                <h6 class="upload-text mb-2">Drop your file here or click to browse</h6>
                <p class="text-muted small mb-0">Maximum file size: 500MB<br>Accepted formats: .PSD, .ZIP</p>
            </label>
        </div>

        <!-- Upload Progress Bar -->
        <div id="uploadProgressContainer" class="mt-3 d-none">
            <p class="mb-1 small">Uploading file... <span id="uploadPercentage">0%</span></p>
            <div class="progress">
                <div id="uploadProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
            </div>
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
            <div id="fileDetails" class="mt-3">
                <p id="fileName" class="mb-1"></p>
                <p id="fileSize" class="mb-1"></p>
                <p id="fileType" class="mb-0"></p>
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm mt-3" onclick="removeUploadedFile()">
                Remove File
            </button>
        </div>
    </div>
</div>

<script>
function handleFileUpload() {
    const fileInput = document.getElementById('image');
    const file = fileInput.files[0];

    if (!file) return;

    // Validate file extension
    const fileExtension = file.name.split('.').pop().toLowerCase();
    if (fileExtension !== 'zip' && fileExtension !== 'psd') {
        alert('Invalid file type. Only PSD and ZIP files are allowed.');
        fileInput.value = '';
        return;
    }

    // Validate file size (500MB)
    if (file.size > 500 * 1024 * 1024) {
        alert('File size exceeds the maximum limit of 500MB.');
        fileInput.value = '';
        return;
    }

    // Store the file information in sessionStorage
    const designData = {
        fileName: file.name,
        fileSize: file.size,
        fileType: fileExtension.toUpperCase(),
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

    // Show upload progress (simulated)
    simulateUploadProgress();
}

function simulateUploadProgress() {
    const progressContainer = document.getElementById('uploadProgressContainer');
    const progressBar = document.getElementById('uploadProgressBar');
    const percentageText = document.getElementById('uploadPercentage');
    
    // Reset progress
    progressBar.style.width = '0%';
    percentageText.textContent = '0%';
    
    // Show progress container
    progressContainer.classList.remove('d-none');
    
    // Simulate upload progress
    let progress = 0;
    const progressInterval = setInterval(() => {
        progress += Math.floor(Math.random() * 8) + 2; // Random increment between 2-10%
        
        if (progress >= 100) {
            progress = 100;
            clearInterval(progressInterval);
            
            // Complete upload
            setTimeout(() => {
                progressContainer.classList.add('d-none');
                displayUploadedFile();
            }, 500);
        }
        
        // Update progress UI
        progressBar.style.width = `${progress}%`;
        percentageText.textContent = `${progress}%`;
    }, 200);
}

function displayUploadedFile() {
    const file = document.getElementById('image').files[0];
    const fileExtension = file.name.split('.').pop().toLowerCase();
    
    // Set appropriate icon based on file type
    const preview = document.getElementById('imagePreview');
    if (fileExtension === 'zip') {
        preview.src = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIj48cGF0aCBkPSJNMjU2IDUxMmMxNDEuNCAwIDI1Ni0xMTQuNiAyNTYtMjU2UzM5Ny40IDAgMjU2IDAgMCAxMTQuNiAwIDI1NnMxMTQuNiAyNTYgMjU2IDI1NnptLTk5LTM2OGg2MHY0MGgtMjB2MjBoMjB2NDBoLTIwdjIwaDIwdjQwaC02MFYxNDR6bS04MCAxMjhoNjBWMTQ0aC02MHYxMjh6bTI0MC0xMjhIMjE3djEyOGgxMDBWMTQ0em0tNDAgMjBoNjB2ODhoLTYwdi04OHoiIGZpbGw9IiMwQjVDRjkiLz48L3N2Zz4=';
        preview.classList.add('file-icon');
    } else if (fileExtension === 'psd') {
        preview.src = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIj48cGF0aCBkPSJNMTA4LjEgOTYuMWMtNC4yLS4xLTguNy4xLTEzLjUuN0MyMC44IDEwMy40LS4xIDE0Ny44IDAgMjA1YzAgMTQ5LjQ4IDEyNC42IDE0Ni43NSAxMjQuNiAyMjUuMSAwIDMzIDI4LjggNTcuNyA2MS40IDU3LjcgOTYuNCAwIDEyNy0yMTguOCAxOTAuOC0yMTguOCAyNSAwIDQzLjQgMjEgNDMuNCA0NS4zIDAgMzQuOC0yNy4zIDc3LjItNjEuNCA3Ny4yLTIzIDAtMjkuNi0xMS4gNC44LTExLjcgMjcuNyAwIDQzLjQtMjQuMSA0My40LTUwLjggMC0yMS43LTEwLjUtMzcuMS0zMC4yLTM3LjEtOTcuNiAwLTEyNiAyMTguOC0xOTAuOCAyMTguOC0yNyAwLTU1LjgtMzAuMS01NS44LTY1LjVDMTMwLjIgMzU1LjMgNCAxMzcuMyA0IDEyNi44YzAtMTQuOSAxMS4zLTI4LjQgMjkuMi0zMC4xIDE5LjctMS45IDI5IDIyLjQuOTkgMjIuNC0xMC44IDAtMTYuMS02LjQtMTYuMS0xMy43IDAtNS43IDYuMi05LjE0IDE0LjYtOS4xNEgzM2MxOS42IDExLjE4IDIzLjIyLTE2LjM0IDc1LjEtMTYuMzR6IiBmaWxsPSIjMDAxZTM2Ii8+PC9zdmc+';
        preview.classList.add('file-icon');
    }
    
    // Update file details
    document.getElementById('fileName').innerHTML = `<strong>File name:</strong> ${file.name}`;
    document.getElementById('fileSize').innerHTML = `<strong>Size:</strong> ${(file.size / 1024 / 1024).toFixed(2)} MB`;
    document.getElementById('fileType').innerHTML = `<strong>Type:</strong> ${fileExtension.toUpperCase()} file`;
    
    // Show preview container
    document.getElementById('imagePreviewContainer').classList.remove('d-none');
    
    // Hide file info container
    document.getElementById('fileInfoContainer').classList.add('d-none');
}

// Remove uploaded file
function removeUploadedFile() {
    const fileInput = document.getElementById('image');
    const fileInfoContainer = document.getElementById('fileInfoContainer');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const progressContainer = document.getElementById('uploadProgressContainer');

    // Clear file input and hide containers
    fileInput.value = '';
    fileInfoContainer.classList.add('d-none');
    fileInfoContainer.innerHTML = '';
    imagePreviewContainer.classList.add('d-none');
    progressContainer.classList.add('d-none');

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

        if (files.length > 0) {
            document.getElementById('image').files = files;
            handleFileUpload();
        }
    }
});

// Helper function to update order data in session storage
function updateOrderData(data) {
    let orderData = {};
    try {
        const storedData = sessionStorage.getItem('orderSummaryData');
        if (storedData) {
            orderData = JSON.parse(storedData);
        }
    } catch (e) {
        console.error('Error parsing order data', e);
    }
    
    // Merge new data with existing data
    orderData = { ...orderData, ...data };
    sessionStorage.setItem('orderSummaryData', JSON.stringify(orderData));
}
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

.file-icon {
    max-height: 100px !important;
    max-width: 100px !important;
    padding: 15px !important;
}

.progress {
    height: 10px;
    border-radius: 5px;
    margin-top: 5px;
}

.progress-bar {
    background-color: #0B5CF9;
}

#fileDetails {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin: 0 auto;
    max-width: 300px;
    text-align: left;
}

#fileDetails p {
    margin-bottom: 8px;
}

.alert {
    border-radius: 8px;
}
</style>
