<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$required = ['photo_id', 'posing_score', 'style_score', 'creativity_score', 'overall_impression'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
        exit();
    }
}

$photo_id = intval($_POST['photo_id']);
$rater_id = $_SESSION['user_id'];
$posing_score = intval($_POST['posing_score']);
$style_score = intval($_POST['style_score']);
$creativity_score = intval($_POST['creativity_score']);
$overall_impression = sanitizeInput($_POST['overall_impression']);

// Validate scores
if ($posing_score < 1 || $posing_score > 10 || 
    $style_score < 1 || $style_score > 10 || 
    $creativity_score < 1 || $creativity_score > 10) {
    echo json_encode(['success' => false, 'message' => 'Scores must be between 1 and 10']);
    exit();
}

// Check if user already rated this photo
$check_stmt = $conn->prepare("SELECT rating_id FROM ratings WHERE rater_id = ? AND photo_id = ?");
$check_stmt->bind_param("ii", $rater_id, $photo_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'You already rated this photo']);
    exit();
}

// Insert rating
$insert_stmt = $conn->prepare("INSERT INTO ratings (rater_id, photo_id, posing_score, style_score, creativity_score, overall_impression) 
                              VALUES (?, ?, ?, ?, ?, ?)");
$insert_stmt->bind_param("iiiiis", $rater_id, $photo_id, $posing_score, $style_score, $creativity_score, $overall_impression);

if (!$insert_stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
    exit();
}

// Calculate new social score for the photo
$total_score = $posing_score + $style_score + $creativity_score;
$social_score = round(($total_score / 30) * 100);

// Update photo's social score
$update_stmt = $conn->prepare("UPDATE photos SET social_score = ? WHERE photo_id = ?");
$update_stmt->bind_param("ii", $social_score, $photo_id);
$update_stmt->execute();

echo json_encode(['success' => true, 'social_score' => $social_score]);
?>