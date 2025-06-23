<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
function getRandomPhotos($conn, $limit = 2, $exclude_user_id = null) {
    $query = "SELECT p.*, u.username, u.profile_pic 
              FROM photos p
              JOIN users u ON p.user_id = u.user_id";
    
    if ($exclude_user_id) {
        $query .= " WHERE p.user_id != ?";
    }
    
    $query .= " ORDER BY RAND() LIMIT ?";
    
    $stmt = $conn->prepare($query);
    
    if ($exclude_user_id) {
        $stmt->bind_param("ii", $exclude_user_id, $limit);
    } else {
        $stmt->bind_param("i", $limit);
    }
    
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function calculateSocialScore($posing, $style, $creativity) {
    $total = $posing + $style + $creativity;
    return round(($total / 30) * 100);
}

function getUserById($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
?>