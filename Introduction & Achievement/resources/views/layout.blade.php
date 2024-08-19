<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@200;900&display=swap" rel="stylesheet">
    <title>@yield('title', 'E-COPS SITE')</title>

    <style>
        body {
            margin: 0;
            font-family: 'Source Sans 3', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        nav {
            background-color: #263343;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            position: fixed;
            top: 0;
        }

        nav a {
            color: #f5f5f5;
            text-decoration: none;
            font-size: 18px;
            margin-left: 20px;
        }

        nav a:hover {
            color: #fa7070;
        }

        .navbar_logo a {
            font-size: 40px;
            color: #f5f5f5;
            text-decoration: none;
        }

        .navbar_logo a:hover {
            color: #fa7070;
        }

        .navbar_links {
            display: flex;
            align-items: center;
        }

        .navbar_links a {
            margin-left: 20px;
            font-size: 18px;
        }

        section {
            padding: 60px 20px;
            max-width: 1000px;
            margin: 0 auto;
            background-color: transparent;
            text-align: center;
        }
    </style>
</head>

<body>

<!-- 네비게이션 바 -->
<nav>
    <div class="navbar_logo">
        <a href="{{ url('/ecops/site') }}">E-COPS</a>
    </div>
    <div class="navbar_links">
        <a href="{{ url('/ecops/site') }}">Home</a>
        <a href="{{ url('/ecops/introduction') }}">Introduction</a>
        <a href="{{ url('/ecops/achievement') }}">Achievement</a>
        <a href="#">Q&A</a>
        <a href="#">Login</a>
    </div>
</nav>

<!-- 컨텐츠 섹션 -->
<section>
    @yield('content')
</section>

</body>
</html>
