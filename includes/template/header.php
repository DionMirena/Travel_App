<!doctype html>
<html>

<?php if (!empty($error_message)): ?>
    <div class="error-message">
        <?= htmlspecialchars($error_message) ?>
    </div>
<?php endif; ?>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="styles.css">
  <title>Travel App</title>
  <style>
    .topbar {
      background: #007bff;
      color: white;
      padding: 15px 0;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    .header-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logo {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: white;
      font-size: 24px;
      font-weight: bold;
      margin-left: 0;
    }
    .logo-icon {
      width: 40px;
      height: 40px;
      background: rgba(255,255,255,0.2);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 10px;
      color: white;
      font-weight: bold;
      font-size: 20px;
      border: 2px solid white;
    }
    .user-info {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .user-info a {
      color: white;
      text-decoration: none;
      padding: 5px 10px;
      border-radius: 4px;
      transition: background 0.3s;
    }
    .user-info a:hover {
      background: rgba(255,255,255,0.2);
    }
    .places-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .place-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        background: white;
    }
    .hotels {
        margin-top: 15px;
    }
    .hotel-card {
        border: 1px solid #eee;
        border-radius: 5px;
        padding: 10px;
        margin: 10px 0;
        background: #f9f9f9;
    }

    .success-message {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #4CAF50;
        color: white;
        padding: 15px 20px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        z-index: 1000;
        animation: slideIn 0.5s ease-out;
    }
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
  </style>
</head>
<body>
<header class="topbar">
    <div class="container">
      <div class="header-content">
        <a href="index.php" class="logo" style="margin-left: 0; padding-left: 0;">
          <div class="logo-icon">T</div>
          Travel App
        </a>
        <div class="user-info">
          <!-- Removed user name span -->
          <a href="profile.php">Profile</a>
          <a href="bookings.php">My Bookings</a>
          <a href="logout.php">Logout</a>
        </div>
      </div>
    </div>
</header>
<main class="container">