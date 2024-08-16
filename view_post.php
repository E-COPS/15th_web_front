<!-- view_post.php -->
<?php include 'includes/header.php'; ?>
<?php include 'db/db.php'; ?>

<?php
$post_id = $_GET['id'];
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if ($post) {
    echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
    echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";

    if ($post['image']) {
        echo "<img src='" . htmlspecialchars($post['image']) . "' alt='Post Image'>";
    }

    // 피드백 표시
    $sql = "SELECT * FROM feedback WHERE post_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$post_id]);
    $feedbacks = $stmt->fetchAll();

    echo "<h3>Feedback:</h3>";
    foreach ($feedbacks as $feedback) {
        echo "<p>" . htmlspecialchars($feedback['comment']) . "</p>";
    }
}
?>

<form action="feedback.php" method="post">
    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
    <label for="comment">Leave Feedback:</label>
    <textarea name="comment" required></textarea><br>
    <input type="submit" value="Submit Feedback">
</form>

<?php include 'includes/footer.php'; ?>
