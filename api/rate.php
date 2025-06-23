<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

// Validate required fields
$required = ['photo_id', 'posing_score', 'style_score', 'creativity_score', 'overall_impression'];
foreach ($required as $field) {
    if (!isset($_POST[$field]) || $_POST[$field] === '') {
        echo json_encode(['success' => false, 'message' => "Missing field: $field"]);
        exit;
    }
}

// Sanitize inputs
$photo_id = intval($_POST['photo_id']);
$posing_score = intval($_POST['posing_score']);
$style_score = intval($_POST['style_score']);
$creativity_score = intval($_POST['creativity_score']);
$overall_impression = trim($_POST['overall_impression']);

// Validate scores are between 1-10
if ($posing_score < 1 || $posing_score > 10 || 
    $style_score < 1 || $style_score > 10 || 
    $creativity_score < 1 || $creativity_score > 10) {
    echo json_encode(['success' => false, 'message' => 'Scores must be between 1-10']);
    exit;
}

// Validate impression is one of the allowed values
$allowed_impressions = ['Hot', 'Elegant', 'Confident'];
if (!in_array($overall_impression, $allowed_impressions)) {
    echo json_encode(['success' => false, 'message' => 'Invalid impression value']);
    exit;
}

try {
    // Insert rating into database
    $stmt = $conn->prepare("INSERT INTO ratings 
        (photo_id, rater_id, posing_score, style_score, creativity_score, overall_impression) 
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiss", $photo_id, $_SESSION['user_id'], $posing_score, $style_score, $creativity_score, $overall_impression);
    $stmt->execute();

    // Update photo's social score (example - adjust as needed)
    $stmt = $conn->prepare("UPDATE photos SET social_score = social_score + 1 WHERE photo_id = ?");
    $stmt->bind_param("i", $photo_id);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log("Rating error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error']);
}