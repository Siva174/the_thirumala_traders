<?php
require_once __DIR__ . '/../inc/functions.php';
if (!empty($_SESSION['admin'])) { header('Location: dashboard.php'); exit; }
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    if (hash_equals(ADMIN_USER, $_POST['user'] ?? '') && hash_equals(ADMIN_PASS, $_POST['pass'] ?? '')) {
        session_regenerate_id(true);
        $_SESSION['admin'] = true;
        header('Location: dashboard.php'); exit;
    }
    $err = 'Wrong username or password. Try again.';
}
$base = '../'; $title = 'Admin login';
?><!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin login | <?= e(SHOP_NAME) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/style.css">
</head>
<body class="login-body">
<form class="login" method="post">
  <img src="../assets/logo.svg" alt="" width="72" height="72">
  <h1><?= e(SHOP_NAME) ?></h1>
  <p>Admin login</p>
  <?php if ($err): ?><div class="alert"><?= e($err) ?></div><?php endif; ?>
  <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">
  <label>Username<input name="user" required autofocus autocomplete="username"></label>
  <label>Password<input name="pass" type="password" required autocomplete="current-password"></label>
  <button class="btn" type="submit">Log in</button>
  <a class="back" href="../index.php">Back to website</a>
</form>
</body></html>
