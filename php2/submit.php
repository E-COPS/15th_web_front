<!-- submit.php -->
<?php include 'includes/header.php'; ?>
<?php include 'db/db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = '';

    // 이미지 업로드 처리
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = 'images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // 데이터베이스에 게시물 저장
    $sql = "INSERT INTO posts (user_id, title, content, image) VALUES (1, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $content, $image]);

    echo "<p>Post submitted successfully!</p>";
}
?>

<form action="submit.php" method="post" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" name="title" required><br>

    <label for="content">Content:</label>
    <textarea name="content" required></textarea><br>

    <label for="image">Upload Image:</label>
    <input type="file" name="image"><br>

    <input type="submit" value="Submit">
</form>

<?php include 'includes/footer.php'; ?>
