<?php
// Ensure config.php is loaded first
require_once __DIR__ . '/includes/config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = "Upload Photo";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token if you have it implemented
    // if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    //     $error = 'Invalid form submission';
    // } else {
        $caption = isset($_POST['caption']) ? sanitizeInput($_POST['caption']) : '';
        $category = isset($_POST['category']) ? sanitizeInput($_POST['category']) : '';
        $user_id = $_SESSION['user_id'];
        
        // Validate category
        if (!in_array($category, ['fashion', 'portrait', 'concept'])) {
            $error = 'Invalid category selected';
        }
        
        // File upload validation
        if (!isset($_FILES['photo']) || empty($_FILES['photo']['name'])) {
            $error = 'Please select a photo to upload';
        } else {
            $target_dir = __DIR__ . '/' . UPLOAD_DIR;
            
            // Create uploads directory if it doesn't exist
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            
            $imageFileType = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            $new_filename = uniqid() . '.' . $imageFileType;
            $target_path = $target_dir . $new_filename;
            
            // Check if image file is an actual image
            $check = getimagesize($_FILES['photo']['tmp_name']);
            if ($check === false) {
                $error = 'File is not an image.';
            } elseif ($_FILES['photo']['size'] > MAX_FILE_SIZE) {
                $error = 'Sorry, your file is too large (max ' . (MAX_FILE_SIZE / (1024 * 1024)) . 'MB).';
            } elseif (!in_array($imageFileType, ALLOWED_FILE_TYPES)) {
                $error = 'Sorry, only ' . implode(', ', ALLOWED_FILE_TYPES) . ' files are allowed.';
            } elseif (move_uploaded_file($_FILES['photo']['tmp_name'], $target_path)) {
                // Insert into database
                $stmt = $conn->prepare("INSERT INTO photos (user_id, image_path, caption, category) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("isss", $user_id, $new_filename, $caption, $category);
                
                if ($stmt->execute()) {
                    $success = 'Photo uploaded successfully!';
                } else {
                    $error = 'Database error: ' . $stmt->error;
                    // Remove the uploaded file if database insert failed
                    if (file_exists($target_path)) {
                        unlink($target_path);
                    }
                }
            } else {
                $error = 'Sorry, there was an error uploading your file.';
                error_log("Upload error: " . $_FILES['photo']['error']);
            }
        }
    // }
}
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Upload Photo</h2>
            
            <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                <!-- CSRF token if you implement it -->
                <!-- <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> -->
                
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" class="form-control" id="photo" name="photo" required accept="image/*">
                    <div class="invalid-feedback">
                        Please select a photo to upload.
                    </div>
                    <small class="form-text text-muted">
                        Maximum file size: <?php echo (MAX_FILE_SIZE / (1024 * 1024)); ?>MB. Allowed formats: <?php echo implode(', ', ALLOWED_FILE_TYPES); ?>
                    </small>
                </div>
                
                <div class="mb-3">
                    <label for="caption" class="form-label">Caption (Optional)</label>
                    <textarea class="form-control" id="caption" name="caption" rows="3"><?php echo isset($_POST['caption']) ? htmlspecialchars($_POST['caption']) : ''; ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="">Select a category</option>
                        <option value="fashion" <?php echo (isset($_POST['category']) && $_POST['category'] === 'fashion') ? 'selected' : ''; ?>>Fashion</option>
                        <option value="portrait" <?php echo (isset($_POST['category']) && $_POST['category'] === 'portrait') ? 'selected' : ''; ?>>Portrait</option>
                        <option value="concept" <?php echo (isset($_POST['category']) && $_POST['category'] === 'concept') ? 'selected' : ''; ?>>Concept</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a category.
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>

<script>
// Client-side form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>