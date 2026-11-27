<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';
if (!empty($_SESSION['user'])) { header('Location: index.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    try {
        $stmt = db()->prepare('SELECT id,name,email,password,role FROM users WHERE email=? AND status="active" LIMIT 1');
        $stmt->execute([$email]); $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true); unset($user['password']); $_SESSION['user'] = $user;
            header('Location: index.php'); exit;
        }
        $error = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง';
    } catch (Throwable $e) {
        $error = 'ยังเชื่อมต่อฐานข้อมูลไม่ได้ กรุณานำเข้า database.sql และตรวจสอบ config/database.php';
    }
}
?>
<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>เข้าสู่ระบบ | Mellow Café</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="login-page">
    <div class="login-shell">
        <section class="login-art">
            <div class="login-mark">m</div><span class="login-kicker">WELCOME TO</span>
            <h1>Mellow Café</h1>
            <p>Good coffee, sweet moments.</p>
            <div class="login-cup">☕</div><small>POINT OF SALE · STORE MANAGEMENT</small>
        </section>
        <section class="login-card">
            <div class="login-heading"><span class="eyebrow">MELLOW CAFÉ / STAFF</span>
                <h2>เข้าสู่ระบบ</h2>
                <p>กรุณาเข้าสู่ระบบเพื่อเริ่มจัดการร้านค้า</p>
            </div>
            <?php if ($error): ?>
            <div class="login-error">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
            <form method="post" action="login.php" class="login-form"><label for="email">อีเมลผู้ใช้งาน</label><input
                    id="email" name="email" type="email" placeholder="admin@mellowcafe.local" required
                    autocomplete="username"><label for="password">รหัสผ่าน</label><input id="password" name="password"
                    type="password" placeholder="กรอกรหัสผ่าน" required autocomplete="current-password"><button
                    class="primary login-submit" type="submit">เข้าสู่ระบบ <span>→</span></button></form>
            <div class="login-hint"><b>บัญชีทดลองเริ่มต้น</b><br>admin@mellowcafe.local<br>รหัสผ่าน: admin123</div><a
                class="login-back" href="README.md">คู่มือการติดตั้งระบบ</a>
        </section>
    </div>
</body>

</html>