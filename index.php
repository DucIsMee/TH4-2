<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #0d0f1a;
            --card: #13162a;
            --border: #1e2340;
            --accent: #4f8ef7;
            --accent2: #a78bfa;
            --text: #e8eaf6;
            --muted: #6b7280;
            --success: #34d399;
            --error: #f87171;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated background orbs */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 8s ease-in-out infinite;
            pointer-events: none;
        }
        body::before {
            width: 500px; height: 500px;
            background: var(--accent);
            top: -150px; left: -100px;
        }
        body::after {
            width: 400px; height: 400px;
            background: var(--accent2);
            bottom: -100px; right: -80px;
            animation-delay: -4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 48px 44px;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
            box-shadow: 0 0 60px rgba(79, 142, 247, 0.08);
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
        }
        .logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .logo-text { font-size: 18px; font-weight: 700; color: var(--text); }

        h1 {
            font-size: 26px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
        }
        .subtitle {
            color: var(--muted);
            font-size: 14px;
            font-weight: 300;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 8px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 13px 16px;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(79,142,247,0.15);
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border: none;
            border-radius: 10px;
            color: #fff;
            font-family: 'Sora', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: opacity 0.2s, transform 0.15s;
        }
        .btn:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-error { background: rgba(248,113,113,0.12); color: var(--error); border: 1px solid rgba(248,113,113,0.25); }
        .alert-success { background: rgba(52,211,153,0.12); color: var(--success); border: 1px solid rgba(52,211,153,0.25); }

        .footer-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: var(--muted);
        }
        .footer-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }
        .footer-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: welcome.php");
    exit();
}

$error = '';
$success = '';

if (isset($_GET['registered'])) {
    $success = '✅ Đăng ký thành công! Vui lòng đăng nhập.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config.php';

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = '⚠️ Vui lòng nhập đầy đủ thông tin.';
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: welcome.php");
                exit();
            } else {
                $error = '❌ Đăng nhập thất bại! Sai mật khẩu.';
            }
        } else {
            $error = '❌ Đăng nhập thất bại! Tên người dùng không tồn tại.';
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<div class="card">
    <div class="logo">
        <div class="logo-icon">🔐</div>
        <span class="logo-text">TH4-2</span>
    </div>

    <h1>Đăng Nhập</h1>
    <p class="subtitle">Chào mừng trở lại! Vui lòng đăng nhập để tiếp tục.</p>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php">
        <div class="form-group">
            <label for="username">Tên người dùng</label>
            <input type="text" id="username" name="username" placeholder="Nhập username..." 
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" autocomplete="username">
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" placeholder="Nhập mật khẩu..." autocomplete="current-password">
        </div>
        <button type="submit" class="btn">Đăng Nhập →</button>
    </form>

    <div class="footer-link">
        Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
    </div>
</div>

</body>
</html>
