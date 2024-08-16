<!-- feedback.php -->
<?php include 'db/db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    $comment = $_POST['comment'];

    // 피드백 저장
    $sql = "INSERT INTO feedback (post_id, user_id, comment) VALUES (?, 1, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$post_id, $comment]);

    header("Location: view_post.php?id=$post_id");
    exit;
}
?>
