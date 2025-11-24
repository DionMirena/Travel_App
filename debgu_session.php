<?php
session_start();
require 'db.php';

echo "<h2>Session Debug Info</h2>";
echo "Session ID: " . session_id() . "<br>";
echo "User ID in session: " . ($_SESSION['user_id'] ?? 'Not set') . "<br>";
echo "User Name in session: " . ($_SESSION['user_name'] ?? 'Not set') . "<br>";

$users = $pdo->query("SELECT id, name, email FROM users LIMIT 5")->fetchAll();
echo "<h3>First 5 users in database:</h3>";
foreach ($users as $user) {
    echo "ID: {$user['id']} | Name: {$user['name']} | Email: {$user['email']}<br>";
}
?>