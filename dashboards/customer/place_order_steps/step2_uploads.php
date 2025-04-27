<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <link href="../../../public/assets/css/step2_uploads.css" rel="stylesheet">
    <link href="../../../public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h2 class="text-center mb-4">Image</h2>
        
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            
            <!-- Image preview -->
            <div class="form-group" id="imagePreviewContainer" style="display:none;">
                <img id="imagePreview" class="img-fluid" src="" alt="Image Preview">
            </div>
            
            <!-- Custom Image upload button -->
            <div class="form-group">
                <label for="image" class="btn btn-primary custom-file-upload">Choose Image</label>
                <input type="file" class="form-control-file" name="image" id="image" required onchange="previewImage()" style="display: none;">
            </div>
            
            <!-- Description input -->
            <div class="form-group">
                <label for="description">Image Description</label>
                <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
            </div>
        </form>
    </div>

    <script src="../../../public/assets/bootstrap/js/jquery.min.js"></script>
    <script src="../../../public/assets/bootstrap/js/popper.min.js"></script>
    <script src="../../../public/assets/bootstrap/js/bootstrap.min.js"></script>

    <script>
        // Function to preview image
        function previewImage() {
            const file = document.getElementById('image').files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = reader.result;
                document.getElementById('imagePreviewContainer').style.display = 'block'; // Show image preview container
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                document.getElementById('imagePreviewContainer').style.display = 'none'; // Hide image preview if no file is selected
            }
        }
    </script>
</body>
</html>
