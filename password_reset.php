<?php
require 'db.php';

$token = $_GET['token'] ?? '';
$msg = "";

$stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token=? AND reset_expires > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    die("Invalid or expired token.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newpass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $pdo->prepare("UPDATE users SET password=?, reset_token=NULL, reset_expires=NULL WHERE id=?")
        ->execute([$newpass, $user['id']]);

    $msg = "Password reset successful! <a href='login.php'>Login</a>";
}
?>
<!doctype html>
<html>
<body>
<h2>Create New Password</h2>
<p><?= $msg ?></p>

<form method="POST">
    <input type="password" name="password" placeholder="New password" required>
    <button type="submit">Reset Password</button>
</form>

</body>
</html>
