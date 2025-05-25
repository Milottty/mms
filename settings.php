<?php
session_start();
include_once "config.php";
include_once "header.php";

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch user settings
$username = $_SESSION['username'];
$userStmt = $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
$userStmt->bindParam(':username', $username);
$userStmt->execute();
$user = $userStmt->fetch();

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = $_POST['theme'];
    $language = $_POST['language'];

    $updateStmt = $conn->prepare("UPDATE users SET theme = :theme, language = :language WHERE username = :username");
    $updateStmt->bindParam(':theme', $theme);
    $updateStmt->bindParam(':language', $language);
    $updateStmt->bindParam(':username', $username);

    if ($updateStmt->execute()) {
        $_SESSION['theme'] = $theme;
        $_SESSION['language'] = $language;
        header("Location: settings.php?updated=true");
        exit;
    } else {
        echo "Failed to update settings.";
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
    background-color: <?= $user['theme'] === 'dark' ? '#121212' : '#f9f9f9' ?>;
    color: <?= $user['theme'] === 'dark' ? '#ffffff' : '#000000' ?>;
  }
  .form-container {
    max-width: 700px;
    margin: 50px auto;
    background-color: <?= $user['theme'] === 'dark' ? '#1e1e1e' : '#ffffff' ?>;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  }
  label {
    font-weight: bold;
  }
  .form-control, .form-select {
    background-color: <?= $user['theme'] === 'dark' ? '#2c2c2c' : '#ffffff' ?>;
    color: <?= $user['theme'] === 'dark' ? '#fff' : '#000' ?>;
    border: 1px solid #444;
  }
  .form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: none;
  }
  .btn-primary {
    background-color: #0d6efd;
    border: none;
  }
</style>

<div class="container form-container">
  <h3>Personal Settings</h3>
  <?php if (isset($_GET['updated'])): ?>
    <div class="alert alert-success">Settings updated successfully!</div>
  <?php endif; ?>
  <form method="POST" action="setting.php">
    <div class="mb-3">
      <label for="theme" class="form-label">Theme</label>
      <select class="form-select" id="theme" name="theme">
        <option value="dark" <?= $user['theme'] === 'dark' ? 'selected' : '' ?>>Dark</option>
        <option value="light" <?= $user['theme'] === 'light' ? 'selected' : '' ?>>Light</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="language" class="form-label">Language</label>
      <select class="form-select" id="language" name="language">
        <option value="en" <?= $user['language'] === 'en' ? 'selected' : '' ?>>English</option>
        <option value="de" <?= $user['language'] === 'de' ? 'selected' : '' ?>>German</option>
        <option value="sq" <?= $user['language'] === 'sq' ? 'selected' : '' ?>>Albanian</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Save Preferences</button>
  </form>
</div>

<?php include_once "footer.php"; ?>
