<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);

    echo "<script>alert('Message sent successfully!'); window.location.href='index.php#contact';</script>";
}
?>