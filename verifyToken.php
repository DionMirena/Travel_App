<?php
require 'db.php';
$token = $_GET['token'] ?? '';

if ($token) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE verify_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    
    if ($user) {
        $pdo->prepare("UPDATE users SET is_verified=1, verify_token=NULL WHERE id=?")->execute([$user['id']]);
        $message = "Account verified successfully! <a href='login.php'>Login here</a>";
    } else {
        $message = "Invalid or expired verification token.";
    }
} else {
    $message = "No verification token provided.";
}
?>
<!doctype html>
<html>
<head>
    <title>Email Verification</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="centered">
    <div class="card">
        <h2>Email Verification</h2>
        <p><?= $message ?></p>
    </div>
</body>
</html>