<?php
// 데이터베이스 연결
$host = 'localhost';
$port ='3307';
$dbname = 'ecops';
$username = 'root';
$password = 'root';
$dsn = "mysql:host=$host;$port=$port;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB 연결에 실패했습니다: " . $e->getMessage());
}

// 최근 게시물 가져오기
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 5");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-COPS</title>
    <link rel="stylesheet" href="assets/style.css">

    <!-- index.php 파일의 head 태그 내에 추가 -->
<script src="assets/script.js"></script>

</head>
<body>
    <header>
        <h1>Write Up 풀이 공유</h1>
        <nav>
            <a href="index.php">홈</a>
            <a href="submit.php">문제 풀이 제출</a>
        </nav>
    </header>

    <main>
        <h2>최근 게시물</h2>
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p><?php echo htmlspecialchars(substr($post['content'], 0, 150)) . '...'; ?></p>
                    <a href="view_post.php?id=<?php echo $post['id']; ?>">자세히 보기</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>게시물이 없습니다.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; E-COPS</p>
    </footer>
</body>
</html>
