<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입 페이지</title>
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

        .signup-container {
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

        .signup-button {
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

        .signup-button:hover {
            background-color: #FA7070;
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
        }

        .login-link a {
            color: #FA7070;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="signup-container">
        <h2>회원가입</h2>

        <?php
        // 오류 및 성공 메시지 초기화
        $error_message = '';
        $success_message = '';

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

        // 회원가입 폼이 제출되었을 때
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm-password'];

            // 폼 유효성 검사
            if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                $error_message = '모든 필드를 입력해 주세요.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_message = '유효한 이메일 주소를 입력해 주세요.';
            } elseif ($password !== $confirm_password) {
                $error_message = '비밀번호가 일치하지 않습니다.';
            } else {
                // 이메일 중복 확인
                $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user) {
                    $error_message = '이미 사용 중인 이메일입니다.';
                } else {
                    // 비밀번호 해시화
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // 새로운 사용자 데이터 삽입
                    $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
                    if ($stmt->execute([$name, $email, $hashed_password])) {
                        $success_message = '회원가입이 완료되었습니다. 로그인하세요.';
                    } else {
                        $error_message = '회원가입 중 오류가 발생했습니다. 다시 시도해 주세요.';
                    }
                }
            }
        }
        ?>

        <!-- 회원가입 폼 -->
        <form action="signup.php" method="POST">
            <?php if ($error_message): ?>
                <div class="error-message"><?= $error_message ?></div>
            <?php endif; ?>
            <?php if ($success_message): ?>
                <div class="success-message"><?= $success_message ?></div>
            <?php endif; ?>
            <div class="input-group">
                <label for="name">이름</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required>
            </div>
            <div class="input-group">
                <label for="email">이메일</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
            </div>
            <div class="input-group">
                <label for="password">비밀번호</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="confirm-password">비밀번호 확인</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            <button type="submit" class="signup-button">가입하기</button>
        </form>

        <div class="login-link">
            <a href="login.php">이미 계정이 있으신가요? 로그인</a>
        </div>
    </div>

</body>
</html>
