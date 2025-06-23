<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

header('Content-Type: text/html');

if (!isLoggedIn()) {
    echo '<div class="col-12 text-center"><p>Please login to rate photos.</p></div>';
    exit();
}

// Get random photos excluding the current user's photos
$sql = "SELECT p.photo_id, p.image_path, p.caption, u.username, u.age, u.gender, u.profile_pic
        FROM photos p
        JOIN users u ON p.user_id = u.user_id
        WHERE p.user_id != ?
        ORDER BY RAND() LIMIT 2";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows < 2) {
    echo '<div class="col-12 text-center"><p>Not enough photos available for rating.</p></div>';
    exit();
}

$photos = $result->fetch_all(MYSQLI_ASSOC);

foreach ($photos as $index => $photo) {
    $photoNumber = $index + 1;
    ?>
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <img src="<?php echo URL_ROOT . '/' . UPLOAD_DIR . $photo['image_path']; ?>" 
                 class="card-img-top" alt="<?php echo htmlspecialchars($photo['caption']); ?>">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <img src="<?php echo URL_ROOT . '/' . UPLOAD_DIR . $photo['profile_pic']; ?>" 
                         class="rounded-circle me-2" width="40" height="40">
                    <div>
                        <h5 class="mb-0"><?php echo htmlspecialchars($photo['username']); ?></h5>
                        <small class="text-muted"><?php echo $photo['age']; ?> years</small>
                    </div>
                </div>
                
                <?php if (!empty($photo['caption'])): ?>
                <p class="card-text"><?php echo htmlspecialchars($photo['caption']); ?></p>
                <?php endif; ?>
                
                <div class="rating-buttons mb-3">
                    <button class="btn btn-outline-danger btn-sm impression-btn" 
                            data-photo-id="<?php echo $photo['photo_id']; ?>" 
                            data-impression="Hot">Hot 🔥</button>
                    <button class="btn btn-outline-primary btn-sm impression-btn" 
                            data-photo-id="<?php echo $photo['photo_id']; ?>" 
                            data-impression="Elegant">Elegant 🔥🔥</button>
                    <button class="btn btn-outline-success btn-sm impression-btn" 
                            data-photo-id="<?php echo $photo['photo_id']; ?>" 
                            data-impression="Confident">Confident 🔥🔥🔥</button>
                </div>
                
                <div class="rating-sliders">
                    <div class="mb-2">
                        <label for="posing<?php echo $photoNumber; ?>" class="form-label">Posing 💃🏼</label>
                        <input type="range" class="form-range slider" min="1" max="10" value="5" 
                               id="posing<?php echo $photoNumber; ?>" 
                               data-photo-id="<?php echo $photo['photo_id']; ?>"
                               data-category="posing">
                        <div class="d-flex justify-content-between">
                            <small>1</small>
                            <span id="posingValue<?php echo $photoNumber; ?>">5</span>
                            <small>10</small>
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <label for="style<?php echo $photoNumber; ?>" class="form-label">Style 👗</label>
                        <input type="range" class="form-range slider" min="1" max="10" value="5" 
                               id="style<?php echo $photoNumber; ?>" 
                               data-photo-id="<?php echo $photo['photo_id']; ?>"
                               data-category="style">
                        <div class="d-flex justify-content-between">
                            <small>1</small>
                            <span id="styleValue<?php echo $photoNumber; ?>">5</span>
                            <small>10</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="creativity<?php echo $photoNumber; ?>" class="form-label">Creativity 🎨</label>
                        <input type="range" class="form-range slider" min="1" max="10" value="5" 
                               id="creativity<?php echo $photoNumber; ?>" 
                               data-photo-id="<?php echo $photo['photo_id']; ?>"
                               data-category="creativity">
                        <div class="d-flex justify-content-between">
                            <small>1</small>
                            <span id="creativityValue<?php echo $photoNumber; ?>">5</span>
                            <small>10</small>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary btn-sm submit-rating" 
                            data-photo-id="<?php echo $photo['photo_id']; ?>">
                        Submit Rating
                    </button>
                    <small class="text-muted">Social Score: <span class="social-score"><?php echo $photo['social_score']; ?></span></small>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>