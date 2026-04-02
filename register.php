<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
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
            background: var(--accent2);
            top: -150px; right: -100px;
        }
        body::after {
            width: 400px; height: 400px;
            background: var(--accent);
            bottom: -100px; left: -80px;
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
            box-shadow: 0 0 60px rgba(167,139,250,0.08);
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
            background: linear-gradient(135deg, var(--accent2), var(--accent));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
        }
        .logo-text { font-size: 18px; font-weight: 700; color: var(--text); }

        h1 { font-size: 26px; font-weight: 700; color: var(--text); margin-bottom: 6px; }
        .subtitle { color: var(--muted); font-size: 14px; font-weight: 300; margin-bottom: 32px; }

        .form-group { margin-bottom: 20px; }
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
        input:focus {
            border-color: var(--accent2);
            box-shadow: 0 0 0 3px rgba(167,139,250,0.15);
        }

        .hint { font-size: 12px; color: var(--muted); margin-top: 5px; }

        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--accent2), var(--accent));
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
        }
        .alert-error { background: rgba(248,113,113,0.12); color: var(--error); border: 1px solid rgba(248,113,113,0.25); }

        .footer-link { text-align: center; margin-top: 24px; font-size: 14px; color: var(--muted); }
        .footer-link a { color: var(--accent2); text-decoration: none; font-weight: 600; }
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config.php';

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($password) || empty($confirm)) {
        $error = '⚠️ Vui lòng nhập đầy đủ thông tin.';
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $error = '⚠️ Tên người dùng phải từ 3 đến 50 ký tự.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error = '⚠️ Tên người dùng chỉ được chứa chữ cái, số và dấu gạch dưới.';
    } elseif (strlen($password) < 6) {
        $error = '⚠️ Mật khẩu phải có ít nhất 6 ký tự.';
    } elseif ($password !== $confirm) {
        $error = '⚠️ Mật khẩu xác nhận không khớp.';
    } else {
        // Kiểm tra username đã tồn tại chưa
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = '❌ Tên người dùng đã tồn tại. Vui lòng chọn tên khác.';
        } else {
            // Hash mật khẩu và lưu vào DB
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed);

            if ($stmt->execute()) {
                header("Location: index.php?registered=1");
                exit();
            } else {
                $error = '❌ Đăng ký thất bại! Vui lòng thử lại.';
            }
            $stmt->close();
        }
        $check->close();
        $conn->close();
    }
}
?>

<div class="card">
    <div class="logo">
        <div class="logo-icon">✨</div>
        <span class="logo-text">TH4-2</span>
    </div>

    <h1>Đăng Ký</h1>
    <p class="subtitle">Tạo tài khoản mới để bắt đầu trải nghiệm.</p>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <div class="form-group">
            <label for="username">Tên người dùng</label>
            <input type="text" id="username" name="username" placeholder="Nhập username..." 
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" autocomplete="username">
            <p class="hint">Chỉ chữ cái, số, dấu gạch dưới. 3–50 ký tự.</p>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" placeholder="Tối thiểu 6 ký tự..." autocomplete="new-password">
        </div>
        <div class="form-group">
            <label for="confirm_password">Xác nhận mật khẩu</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu..." autocomplete="new-password">
        </div>
        <button type="submit" class="btn">Tạo Tài Khoản →</button>
    </form>

    <div class="footer-link">
        Đã có tài khoản? <a href="index.php">Đăng nhập</a>
    </div>
</div>

</body>
</html>
