<?php
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $errors = []; // 0

    if (mb_strlen($name) > 64) {
        // 1 
        $errors[] = 'Max length 64';
    }
    $email = trim($_POST['email']);

    if (count($errors) > 0) {
        $errors[] = 'Invliad email';
    }

    if (count($errors) > 0) {
        setcookie('profile_update_errors', $error, 5);
        header('Location: /profile.php');
        exit;
    }

    
    $file = $user['photo'] ?? 'assets/default-avatar.jpg';

    if (!empty($_FILES['photo']['name'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $fileName = time() . '_' . basename($_FILES['photo']['name']);
        $filePath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
            $file = $filePath;
        }
    }


    if (!empty($_POST['password'])) {
        if (strlen($_POST['password']) >= 6) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET name=?, email=?, password=?, photo=? WHERE id=?");
            $stmt->execute([$name, $email, $password, $file, $_SESSION['user_id']]);
        } else {
            $msg = "Password must be at least 6 characters long.";
        }
    } else {
        $stmt = $pdo->prepare("UPDATE users SET name=?, email=?, photo=? WHERE id=?");
        $stmt->execute([$name, $email, $file, $_SESSION['user_id']]);
    }

    if (empty($msg)) {
        $msg = "Profile updated successfully!";


        $_SESSION['user_name'] = $name;


        $stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .edit-profile-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .current-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container">
            <div>
                <a href="index.php">Travel App</a> |
                Hello, <?= htmlspecialchars($_SESSION['user_name']) ?> |
                <a href="profile.php">Profile</a> |
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <main class="container edit-profile-container">
        <h1>Edit Profile</h1>
        
        <?php if (!empty($msg)): ?>
            <div class="message <?= strpos($msg, 'successfully') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Current Photo</label><br>
                <img src="<?= !empty($user['photo']) ? htmlspecialchars($user['photo']) : 'assets/default-avatar.jpg' ?>" 
                     alt="Current Photo" class="current-photo">
            </div>

            <div class="form-group">
                <label>Change Profile Picture</label>
                <input type="file" name="photo" accept="image/*">
            </div>

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="form-group">
                <label>New Password (leave blank to keep current)</label>
                <input type="password" name="password" placeholder="Enter new password (min 6 characters)">
            </div>

            <button type="submit" class="btn">Save Changes</button>
            <a href="profile.php" style="margin-left: 10px;">Cancel</a>
        </form>
    </main>
</body>
</html>