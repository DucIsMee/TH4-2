<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào Mừng</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&display=swap" rel="stylesheet">
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
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(79,142,247,0.12), transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .container {
            text-align: center;
            z-index: 1;
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .avatar {
            width: 90px; height: 90px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 40px;
            margin: 0 auto 28px;
            box-shadow: 0 0 40px rgba(79,142,247,0.3);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 40px rgba(79,142,247,0.3); }
            50% { box-shadow: 0 0 60px rgba(79,142,247,0.5); }
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(52,211,153,0.15);
            border: 1px solid rgba(52,211,153,0.3);
            color: var(--success);
            font-size: 12px;
            font-weight: 600;
            padding: 5px 14px;
            border-radius: 100px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        h1 {
            font-size: clamp(28px, 5vw, 42px);
            font-weight: 800;
            color: var(--text);
            margin-bottom: 12px;
            line-height: 1.2;
        }
        h1 span {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            color: var(--muted);
            font-size: 16px;
            font-weight: 300;
            margin-bottom: 40px;
        }

        .info-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px 32px;
            margin-bottom: 32px;
            display: inline-block;
            min-width: 280px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
        }
        .info-item { text-align: left; }
        .info-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 4px; }
        .info-value { font-size: 15px; font-weight: 600; color: var(--text); }

        .divider { width: 1px; height: 40px; background: var(--border); }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 28px;
            background: transparent;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            color: var(--muted);
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-logout:hover {
            border-color: var(--error, #f87171);
            color: #f87171;
            background: rgba(248,113,113,0.08);
        }
    </style>
</head>
<body>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$loginTime = date('H:i - d/m/Y');
?>

<div class="container">
    <div class="avatar">👋</div>
    <div class="badge">✅ Đăng nhập thành công!</div>

    <h1>Chào mừng, <span><?= $username ?>!</span></h1>
    <p class="subtitle">Bạn đã đăng nhập thành công vào hệ thống TH4-2.</p>

    <div class="info-card">
        <div class="info-row">
            <div class="info-item">
                <div class="info-label">Tài khoản</div>
                <div class="info-value">@<?= $username ?></div>
            </div>
            <div class="divider"></div>
            <div class="info-item">
                <div class="info-label">Thời gian</div>
                <div class="info-value"><?= $loginTime ?></div>
            </div>
            <div class="divider"></div>
            <div class="info-item">
                <div class="info-label">Trạng thái</div>
                <div class="info-value" style="color: var(--success);">● Online</div>
            </div>
        </div>
    </div>

    <a href="logout.php" class="btn-logout">🚪 Đăng xuất</a>
</div>

</body>
</html>
