<?php
require_once 'includes/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$user_id = intval($_GET['id']);

// Get user info
$user_stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

if ($user_result->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$user = $user_result->fetch_assoc();
$profilePic = !empty($user['profile_pic']) ? UPLOAD_DIR . $user['profile_pic'] : 'assets/images/default-profile.jpg';

$pageTitle = $user['username'] . "'s Profile";
include 'includes/header.php';
include 'includes/navbar.php';

// Get user's photos
$photos_stmt = $conn->prepare("SELECT * FROM photos WHERE user_id = ? ORDER BY upload_date DESC");
$photos_stmt->bind_param("i", $user_id);
$photos_stmt->execute();
$photos_result = $photos_stmt->get_result();

// Calculate average rating
$ratings_stmt = $conn->prepare("SELECT AVG(posing_score) as avg_posing, 
                                       AVG(style_score) as avg_style, 
                                       AVG(creativity_score) as avg_creativity
                                FROM ratings
                                WHERE photo_id IN (SELECT photo_id FROM photos WHERE user_id = ?)");
$ratings_stmt->bind_param("i", $user_id);
$ratings_stmt->execute();
$ratings_result = $ratings_stmt->get_result();
$ratings = $ratings_result->fetch_assoc();
?>

<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="<?php echo URL_ROOT . '/' . $profilePic; ?>" 
                         class="rounded-circle mb-3" width="150" height="150">
                    <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                    
                    <?php if (!empty($user['age']) || !empty($user['gender'])): ?>
                    <p class="text-muted">
                        <?php 
                        if (!empty($user['age'])) echo $user['age'] . ' years';
                        if (!empty($user['age']) && !empty($user['gender'])) echo ' • ';
                        if (!empty($user['gender'])) echo $user['gender'];
                        ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if (!empty($user['bio'])): ?>
                    <p><?php echo htmlspecialchars($user['bio']); ?></p>
                    <?php endif; ?>
                    
                    <div class="d-flex justify-content-center mb-3">
                        <div class="px-3 text-center">
                            <div class="h5 mb-0"><?php echo $photos_result->num_rows; ?></div>
                            <div class="small text-muted">Photos</div>
                        </div>
                        <div class="px-3 text-center">
                            <div class="h5 mb-0"><?php echo $user['social_score']; ?></div>
                            <div class="small text-muted">Social Score</div>
                        </div>
                    </div>
                    
                    <?php if (isLoggedIn() && $_SESSION['user_id'] == $user_id): ?>
                    <a href="upload.php" class="btn btn-primary btn-sm">Upload Photo</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if ($ratings_result->num_rows > 0): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Average Ratings</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label>Posing 💃🏼</label>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: <?php echo $ratings['avg_posing'] * 10; ?>%" 
                                 aria-valuenow="<?php echo $ratings['avg_posing']; ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="10">
                                <?php echo number_format($ratings['avg_posing'], 1); ?>/10
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label>Style 👗</label>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: <?php echo $ratings['avg_style'] * 10; ?>%" 
                                 aria-valuenow="<?php echo $ratings['avg_style']; ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="10">
                                <?php echo number_format($ratings['avg_style'], 1); ?>/10
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label>Creativity 🎨</label>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: <?php echo $ratings['avg_creativity'] * 10; ?>%" 
                                 aria-valuenow="<?php echo $ratings['avg_creativity']; ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="10">
                                <?php echo number_format($ratings['avg_creativity'], 1); ?>/10
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-8">
            <h4 class="mb-4">Photos</h4>
            
            <?php if ($photos_result->num_rows > 0): ?>
            <div class="row">
                <?php while ($photo = $photos_result->fetch_assoc()): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo URL_ROOT . '/' . UPLOAD_DIR . $photo['image_path']; ?>" 
                             class="card-img-top" alt="<?php echo htmlspecialchars($photo['caption']); ?>">
                        <div class="card-body">
                            <?php if (!empty($photo['caption'])): ?>
                            <p class="card-text"><?php echo htmlspecialchars($photo['caption']); ?></p>
                            <?php endif; ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <?php echo date('M j, Y', strtotime($photo['upload_date'])); ?>
                                </small>
                                <span class="badge bg-primary"><?php echo ucfirst($photo['category']); ?></span>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <small class="text-muted">
                                Social Score: <?php echo $photo['social_score']; ?>
                            </small>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php else: ?>
            <div class="alert alert-info">
                No photos uploaded yet.
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>