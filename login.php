<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인 페이지</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-button {
            width: 100%;
            padding: 10px;
            background-color: #FA7070;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-button:hover {
            background-color: #FA7070;
        }

        .signup-link {
            text-align: center;
            margin-top: 10px;
        }

        .signup-link a {
            color: #FA7070;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>로그인</h2>
        
        <?php
        // 로그인 오류 메시지 초기화
        $error_message = '';

        // 데이터베이스 연결 설정 (MySQL 기준)
        $host = 'localhost';
        $db   = 'club_website';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            // 데이터베이스에 연결
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

        // 로그인 폼이 제출되었을 때
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // 입력된 이메일에 해당하는 데이터를 가져오기 위한 쿼리 준비
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            // 사용자 데이터가 존재하고 비밀번호가 일치하는지 확인
            if ($user && password_verify($password, $user['password'])) {
                // 로그인 성공 시 세션 시작 및 세션 데이터 설정
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['name'];
                
                // 로그인 성공 후 리다이렉션
                header('Location: dashboard.php');
                exit;
            } else {
                // 로그인 실패 시 오류 메시지 설정
                $error_message = '이메일 또는 비밀번호가 잘못되었습니다.';
            }
        }
        ?>

        <!-- 로그인 폼 -->
        <form action="login.php" method="POST">
            <?php if ($error_message): ?>
                <div class="error-message"><?= $error_message ?></div>
            <?php endif; ?>
            <div class="input-group">
                <label for="email">이메일</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">비밀번호</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-button">로그인</button>
        </form>
        
        <div class="signup-link">
            <a href="signup.php">회원가입</a>
        </div>
    </div>

</body>
</html>