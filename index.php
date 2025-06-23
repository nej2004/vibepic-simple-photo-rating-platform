<?php
require_once __DIR__ . '/includes/config.php';

$pageTitle = "Home";
include __DIR__ . '/includes/header.php';
?>

<div class="container py-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="display-4 fw-bold mb-4">VibePic</h1>
            <p class="lead mb-4">
                The Gen Z platform for rating fashion, portrait, and concept photos.
            </p>
            <div class="d-grid gap-2 d-md-flex">
                <a href="register.php" class="btn btn-primary btn-lg px-4 me-md-2">Join Now</a>
                <a href="home.php" class="btn btn-outline-secondary btn-lg px-4">Try Demo</a>
            </div>
        </div>
        <div class="col-md-6">
            <img src="<?= URL_ROOT ?>/assets/images/thumb.webp" class="img-fluid rounded shadow">
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>