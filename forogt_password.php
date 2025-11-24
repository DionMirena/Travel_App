<?php
require 'db.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(32));

        $pdo->prepare("UPDATE users SET reset_token=?, reset_expires=DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id=?")
            ->execute([$token, $user['id']]);

        $resetLink = "http://localhost/reset_password.php?token=" . $token;

        mail($email, "Password Reset", "Click here to reset your password: " . $resetLink);

        $msg = "Reset link has been sent to your email!";
    } else {
        $msg = "Email not found!";
    }
}
?>
<!doctype html>
<html>
<body>
<h2>Reset Password</h2>
<p><?= $msg ?></p>

<form method="POST">
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Send Reset Link</button>
</form>

</body>
</html>
