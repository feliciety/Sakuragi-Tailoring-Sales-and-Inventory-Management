<h5 class="mb-3 fw-bold text-center">Step 2: Upload Your Design File (PSD)</h5>
<p class="text-muted text-center">
    Upload your final design layout. <strong>Only PSD files</strong> are accepted for accurate processing.
</p>

<form action="upload.php" method="POST" enctype="multipart/form-data" class="upload-design-form mt-4">

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
