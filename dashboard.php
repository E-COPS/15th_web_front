<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // 로그인되어 있지 않으면 로그인 페이지로 리다이렉트
    exit;
}
?>

<h2>환영합니다, <?= $_SESSION['username']; ?>님!</h2>
<a href="logout.php">로그아웃</a>
