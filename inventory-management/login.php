<?php

session_start();

// Simple hardcoded credentials (for demo)
$valid_user = 'Chapel';
$valid_pass = 'Chapel2025';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    if ($user === $valid_user && $pass === $valid_pass) {
        $_SESSION['logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Inventory Management</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container" style="max-width:400px;margin-top:80px;">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <div style="color:#e53935; margin-bottom:12px;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" class="login-form" autocomplete="off">
        <input type="text" name="username" placeholder="Username" required autocomplete="off">
        <input type="password" name="password" placeholder="Password" required autocomplete="off">
        <button type="submit" class="btn edit-btn" style="width:100%;">Login</button>
    </form>
</div>
</body>
</html>