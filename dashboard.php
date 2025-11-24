<?php
require '../db.php';

if (empty($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    die("Access denied – Admins only");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

<h1>Welcome Admin</h1>
<a href="places.php">Manage Places</a>

</body>
</html>
