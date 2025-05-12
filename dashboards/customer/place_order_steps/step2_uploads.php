<?php
require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../../config/session_handler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['image'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'No file uploaded',
        ]);
        exit();
    }

    $file = $_FILES['image'];
    $allowedTypes = ['image/vnd.adobe.photoshop', 'application/zip'];

    // Validate file
    if (!in_array($file['type'], $allowedTypes)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Invalid file type. Only PSD and ZIP files are allowed.',
        ]);
        exit();
    }

    if ($file['size'] > 10 * 1024 * 1024) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'File size exceeds the maximum limit of 10MB.',
        ]);
        exit();
    }

    // Process upload
    $uploadDir = __DIR__ . '/../../../public/uploads/design/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uniqueName = uniqid() . '-' . basename($file['name']);
    $filePath = $uploadDir . $uniqueName;

    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Failed to move uploaded file',
        ]);
        exit();
    }

    // Store in database
    $stmt = $pdo->prepare("
        INSERT INTO uploads (
            user_id, 
            file_name, 
            file_path, 
            file_type, 
            file_size
        ) VALUES (
            :user_id, 
            :file_name, 
            :file_path, 
            :file_type, 
            :file_size
        )
    ");

    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'file_name' => $file['name'],
        'file_path' => '../../../../uploads/design/' . $uniqueName,
        'file_type' => $file['type'],
        'file_size' => $file['size'],
    ]);

    echo json_encode([
        'success' => true,
        'filename' => $file['name'],
        'path' => '../../../../uploads/design/' . $uniqueName,
    ]);
    exit();
}
?>


<h5 class="mb-3 fw-bold text-center">Step 2: Upload Your Design File (PSD)</h5>
<p class="text-muted text-center">
    Upload your final design layout. <strong>Only PSD files</strong> are accepted for accurate processing.
</p>

<form action ="" method="POST" enctype="multipart/form-data" class="upload-design-form mt-4">

    <div class="row justify-content-center">
        <!-- Upload Box -->
        <div class="col-md-8">
            <div class="upload-drop-area text-center" id="uploadDropArea">
                <div class="upload-icon mb-3">☁️</div>
                <p class="upload-text fw-semibold mb-1">Drag your PSD file here</p>
                <p class="text-muted small mb-3">or click the button below to browse your device</p>
                <label for="image" class="btn btn-primary px-5 py-3 rounded-pill fw-semibold shadow-sm">📤 Choose File</label>
                <input type="file" class="form-control d-none" name="image" id="image" required onchange="handleFileUpload()">
                <p class="text-muted small mt-3">Accepted format: .PSD only</p>
            </div>

            <!-- File Info -->
            <div class="upload-file-info mt-4 text-center d-none" id="fileInfoContainer">
                <div class="psd-icon mb-2">🖼️</div>
                <p class="fw-semibold mb-1" id="fileNamePreview"></p>
                <p class="text-muted small" id="fileSizePreview"></p>
                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill mt-2" onclick="removeUploadedFile()">Remove / Change File</button>
            </div>
        </div>
    </div>
</form>

<style>
    /* Upload Drag & Drop Design */
.upload-drop-area {
    border: 3px dashed #ccc;
    border-radius: 16px;
    padding: 50px 20px;
    background-color: #f9f9f9;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

.upload-drop-area:hover {
    border-color: #6c5ce7;
    background-color: #f1f1ff;
}

.upload-icon {
    font-size: 3.5rem;
    color: #6c5ce7;
    transition: transform 0.3s ease;
}

.upload-drop-area:hover .upload-icon {
    transform: scale(1.1);
}

.upload-text {
    font-size: 1.25rem;
}

.upload-preview img {
    border: 2px solid #6c5ce7;
    padding: 5px;
    border-radius: 12px;
    transition: transform 0.3s ease;
}

.upload-preview img:hover {
    transform: scale(1.05);
}

textarea#description {
    border-radius: 12px;
    border-color: #ddd;
    transition: border-color 0.3s ease;
}

textarea#description:focus {
    border-color: #6c5ce7;
    box-shadow: 0 0 5px rgba(108, 92, 231, 0.3);
}

</style>

<script>
function handleFileUpload() {
    const fileInput = document.getElementById('image');
    const file = fileInput.files[0];
    const fileInfo = document.getElementById('fileInfoContainer');
    
    if (file) {
        const formData = new FormData();
        formData.append('image', file);

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Store file info in session
                sessionStorage.setItem('uploadedDesign', JSON.stringify({
                    name: data.filename,
                    path: data.path
                }));
                
                // Show file info
                fileInfo.classList.remove('d-none');
                document.getElementById('fileNamePreview').textContent = file.name;
                document.getElementById('fileSizePreview').textContent = 
                    `${(file.size / (1024 * 1024)).toFixed(2)} MB`;
            } else {
                throw new Error(data.error);
            }
        })
        .catch(error => {
            alert(error.message || 'Upload failed. Please try again.');
            fileInput.value = '';
            fileInfo.classList.add('d-none');
        });
    }
}

function removeUploadedFile() {
    const fileInput = document.getElementById('image');
    const fileInfo = document.getElementById('fileInfoContainer');
    
    fileInput.value = '';
    fileInfo.classList.add('d-none');
    sessionStorage.removeItem('uploadedDesign');
}
</script>
