<?php
require_once __DIR__ . '/includes/config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = "Rate Photos";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';

// Get random photo (excluding current user's photos)
$stmt = $conn->prepare("SELECT p.photo_id, p.image_path, p.caption, p.upload_date, p.category, 
                        u.user_id, u.username, u.profile_pic, u.social_score
                        FROM photos p
                        JOIN users u ON p.user_id = u.user_id
                        WHERE p.user_id != ?
                        ORDER BY RAND() LIMIT 1");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$photo = $stmt->get_result()->fetch_assoc();
?>

<div class="container py-4">
    <h2 class="text-center mb-4">Rate Photos</h2>
    
    <?php if (empty($photo)): ?>
    <div class="alert alert-info text-center">
        No photos available for rating. Check back later or <a href="upload.php">upload your own</a>!
    </div>
    <?php else: 
        $uploadDate = new DateTime($photo['upload_date']);
    ?>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="row">
                        <!-- Image Column -->
                        <div class="col-md-7 mb-4 mb-md-0">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <img src="<?php echo UPLOAD_DIR . $photo['image_path']; ?>" 
                                     class="img-fluid rounded-3" 
                                     style="max-height: 70vh; width: auto;"
                                     alt="<?php echo htmlspecialchars($photo['caption'] ?? 'Photo'); ?>">
                            </div>
                        </div>
                        
                        <!-- Rating Column -->
                        <div class="col-md-5">
                            <div class="h-100 d-flex flex-column">
                                <div class="d-flex align-items-center mb-4">
                                    <img src="<?php echo UPLOAD_DIR . $photo['profile_pic']; ?>" 
                                         class="user-avatar rounded-circle me-3" 
                                         width="60" height="60"
                                         alt="<?php echo htmlspecialchars($photo['username']); ?>">
                                    <div>
                                        <h5 class="mb-0"><?php echo htmlspecialchars($photo['username']); ?></h5>
                                        <small class="text-muted">
                                            <?php echo $uploadDate->format('M j, Y'); ?>
                                            • <?php echo ucfirst($photo['category']); ?>
                                        </small>
                                    </div>
                                </div>
                                
                                <?php if (!empty($photo['caption'])): ?>
                                <p class="card-text mb-4"><?php echo htmlspecialchars($photo['caption']); ?></p>
                                <?php endif; ?>
                                
                                <form class="rating-form flex-grow-1 d-flex flex-column" data-photo-id="<?php echo $photo['photo_id']; ?>">
                                    <!-- Overall Impression Selection -->
                                    <div class="mb-4">
                                        <label class="form-label">Overall Impression</label>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="overall_impression" 
                                                   id="hot-<?php echo $photo['photo_id']; ?>" 
                                                   value="Hot" autocomplete="off" checked>
                                            <label class="btn btn-outline-danger" for="hot-<?php echo $photo['photo_id']; ?>">
                                                Hot
                                            </label>
                                            
                                            <input type="radio" class="btn-check" name="overall_impression" 
                                                   id="elegant-<?php echo $photo['photo_id']; ?>" 
                                                   value="Elegant" autocomplete="off">
                                            <label class="btn btn-outline-primary" for="elegant-<?php echo $photo['photo_id']; ?>">
                                                Elegant
                                            </label>
                                            
                                            <input type="radio" class="btn-check" name="overall_impression" 
                                                   id="confident-<?php echo $photo['photo_id']; ?>" 
                                                   value="Confident" autocomplete="off">
                                            <label class="btn btn-outline-success" for="confident-<?php echo $photo['photo_id']; ?>">
                                                Confident
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="posing-<?php echo $photo['photo_id']; ?>" class="form-label d-flex justify-content-between">
                                            <span>Posing</span>
                                            <span class="slider-value">5</span>
                                        </label>
                                        <input type="range" class="form-range slider" min="1" max="10" value="5" 
                                               id="posing-<?php echo $photo['photo_id']; ?>" name="posing">
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="style-<?php echo $photo['photo_id']; ?>" class="form-label d-flex justify-content-between">
                                            <span>Style</span>
                                            <span class="slider-value">5</span>
                                        </label>
                                        <input type="range" class="form-range slider" min="1" max="10" value="5" 
                                               id="style-<?php echo $photo['photo_id']; ?>" name="style">
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="creativity-<?php echo $photo['photo_id']; ?>" class="form-label d-flex justify-content-between">
                                            <span>Creativity</span>
                                            <span class="slider-value">5</span>
                                        </label>
                                        <input type="range" class="form-range slider" min="1" max="10" value="5" 
                                               id="creativity-<?php echo $photo['photo_id']; ?>" name="creativity">
                                    </div>
                                    
                                    <div class="mt-auto d-flex gap-3">
                                        <button type="submit" class="btn btn-primary flex-grow-1 py-2">
                                            Submit Rating
                                        </button>
                                        <button type="button" id="next-photo" class="btn btn-outline-secondary py-2">
                                            Next <i class="fas fa-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </form>
                                
                                <div class="mt-3 text-center">
                                    <small class="text-muted">
                                        Social Score: <?php echo $photo['social_score']; ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update slider values in real-time
    document.querySelectorAll('.slider').forEach(slider => {
        const valueDisplay = slider.closest('.mb-4').querySelector('.slider-value');
        slider.addEventListener('input', function() {
            valueDisplay.textContent = this.value;
        });
    });

    // Handle rating form submission
    document.querySelectorAll('.rating-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const photoId = this.dataset.photoId;
            const submitBtn = this.querySelector('button[type="submit"]');
            const nextBtn = document.getElementById('next-photo');
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Submitting...
            `;
            
            try {
                const response = await fetch('api/rate.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'photo_id': photoId,
                        'posing_score': formData.get('posing'),
                        'style_score': formData.get('style'),
                        'creativity_score': formData.get('creativity'),
                        'overall_impression': formData.get('overall_impression')
                    })
                });

                // First check if response is JSON
                const text = await response.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    throw new Error('Server returned invalid response');
                }
                
                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Failed to submit rating');
                }

                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success mt-3 mb-0';
                alert.textContent = 'Rating submitted successfully!';
                form.appendChild(alert);
                
                // Disable only the submit button and form inputs
                submitBtn.disabled = true;
                form.querySelectorAll('input, button').forEach(el => el.disabled = true);
                
                // Enable next button
                nextBtn.disabled = false;
                
                // Remove message after 3 seconds
                setTimeout(() => {
                    alert.remove();
                }, 3000);
            } catch (error) {
                const alert = document.createElement('div');
                alert.className = 'alert alert-danger mt-3 mb-0';
                alert.textContent = error.message;
                form.appendChild(alert);
                
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Rating';
                
                setTimeout(() => alert.remove(), 5000);
            }
        });
    });

    // Next photo button
    document.getElementById('next-photo')?.addEventListener('click', function() {
        window.location.reload();
    });
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>