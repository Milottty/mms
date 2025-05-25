<!-- <?php
include_once "config.php";
include_once "header.php";
session_start();

// Fetch current settings
$sql = "SELECT * FROM settings LIMIT 1";
$settingsStmt = $conn->prepare($sql);
$settingsStmt->execute();
$settings = $settingsStmt->fetch();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_name = $_POST['site_name'];
    $site_description = $_POST['site_description'];
    $logo_url = $_POST['logo_url'];
    $theme = $_POST['theme'];

    // Update settings
    $updateSql = "UPDATE settings SET site_name = :site_name, site_description = :site_description, logo_url = :logo_url, theme = :theme";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bindParam(':site_name', $site_name);
    $updateStmt->bindParam(':site_description', $site_description);
    $updateStmt->bindParam(':logo_url', $logo_url);
    $updateStmt->bindParam(':theme', $theme);

    if ($updateStmt->execute()) {
        header("Location: setting.php?updated=true");
        exit;
    } else {
        echo "Failed to update settings.";
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
    background-color: #121212;
    color: #fff;
  }
  .form-container {
    max-width: 700px;
    margin: 50px auto;
    background-color: #1e1e1e;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.5);
  }
  label {
    font-weight: bold;
  }
  .form-control, .form-select {
    background-color: #2c2c2c;
    color: #fff;
    border: 1px solid #444;
  }
  .form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: none;
    background-color: #2c2c2c;
  }
  .btn-primary {
    background-color: #0d6efd;
    border: none;
  }
  h3 {
    color: #fff;
    margin-bottom: 20px;
  }
</style>

<div class="container form-container">
  <h3>Site Settings</h3>
  <?php if (isset($_GET['updated'])): ?>
    <div class="alert alert-success">Settings updated successfully!</div>
  <?php endif; ?>
  <form method="POST" action="setting.php">
    <div class="mb-3">
      <label for="site_name" class="form-label">Site Name</label>
      <input type="text" class="form-control" id="site_name" name="site_name" value="<?= htmlspecialchars($settings['site_name']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="site_description" class="form-label">Site Description</label>
      <textarea class="form-control" id="site_description" name="site_description" rows="3" required><?= htmlspecialchars($settings['site_description']) ?></textarea>
    </div>

    <div class="mb-3">
      <label for="logo_url" class="form-label">Logo URL</label>
      <input type="url" class="form-control" id="logo_url" name="logo_url" value="<?= htmlspecialchars($settings['logo_url']) ?>">
    </div>

    <div class="mb-3">
      <label for="theme" class="form-label">Theme</label>
      <select class="form-select" id="theme" name="theme">
        <option value="dark" <?= $settings['theme'] === 'dark' ? 'selected' : '' ?>>Dark</option>
        <option value="light" <?= $settings['theme'] === 'light' ? 'selected' : '' ?>>Light</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Settings</button>
  </form>
</div>

<?php include_once "footer.php"; ?> -->
