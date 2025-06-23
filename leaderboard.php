<?php 
require_once 'includes/config.php';

$pageTitle = "Leaderboard";
include 'includes/header.php';
include 'includes/navbar.php';

// Get top 50 users by social score
$sql = "SELECT u.user_id, u.username, u.profile_pic, 
               COALESCE(SUM(p.social_score), 0) AS total_score
        FROM users u
        LEFT JOIN photos p ON u.user_id = p.user_id
        GROUP BY u.user_id, u.username, u.profile_pic
        ORDER BY total_score DESC
        LIMIT 50";
$result = $conn->query($sql);
?>

<div class="container py-4">
    <h2 class="text-center mb-4">Leaderboard</h2>
    
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Rank</th>
                    <th>User</th>
                    <th>Social Score</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $rank = 1;
                while ($row = $result->fetch_assoc()): 
                    $profilePic = !empty($row['profile_pic']) ? UPLOAD_DIR . $row['profile_pic'] : 'assets/images/default-profile.jpg';
                ?>
                <tr>
                    <td><?php echo $rank; ?></td>
                    <td>
                        <a href="profile.php?id=<?php echo $row['user_id']; ?>" class="text-decoration-none text-dark">
                            <img src="<?php echo URL_ROOT . '/' . $profilePic; ?>" 
                                 width="40" height="40" class="rounded-circle me-2">
                            <?php echo htmlspecialchars($row['username']); ?>
                        </a>
                    </td>
                    <td><?php echo $row['total_score']; ?></td>
                </tr>
                <?php 
                $rank++;
                endwhile; 
                
                if ($rank === 1): ?>
                <tr>
                    <td colspan="3" class="text-center">No users found</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>