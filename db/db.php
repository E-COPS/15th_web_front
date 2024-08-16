<?php
// db.php
$host = 'localhost';
$port = '3307';
$db = 'ecops';
$user = 'root';
$pass = 'root'; // 기본 비밀번호, MAMP의 경우 `root`


$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO("mysql:host=$host; port=$port; dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $db :" . $e->getMessage());
}
?>
