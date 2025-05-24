<?php
session_start();
include_once 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: user_dashboard.php");
    exit();
}

// Fetch user info
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// Check ownership
if (!$data || $data['username'] !== $_SESSION['username']) {
    header("Location: user_dashboard.php");
    exit();
}

include_once 'header.php';
?>

<!-- Font Awesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<!-- Dark Theme Styling -->
<style>
    body {
        background-color: #0d0d0d;
        color: #ffffff;
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
    }

    .sidebar {
        width: 240px;
        height: 100vh;
        background-color: #141414;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 20px;
        border-right: 1px solid #2a2a2a;
    }

    .sidebar a {
        display: block;
        padding: 15px 25px;
        color: #ccc;
        text-decoration: none;
        font-size: 15px;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: #1f1f1f;
        color: #fff;
    }

    .sidebar a i {
        margin-right: 12px;
    }

    .container {
        margin-left: 240px;
        padding: 40px;
        background-color: #0d0d0d;
        min-height: 100vh;
    }

    .form-label {
        color: #e0e0e0;
    }

    .form-control {
        background-color: #1a1a1a;
        border: 1px solid #333;
        color: #fff;
    }

    .form-control:focus {
        border-color: #1dbf73;
        background-color: #1a1a1a;
        color: #fff;
        box-shadow: none;
    }

    .btn-primary {
        background-color: #1dbf73;
        border: none;
    }

    .btn-primary:hover {
        background-color: #17a864;
    }

    .btn-secondary {
        background-color: #444;
        color: #fff;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #555;
    }
</style>

<!-- Sidebar -->
<div class="sidebar">
    <a href="dashboard.php"><i class="fas fa-user"></i> Profile</a>
    <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
    <a href="movies.php"><i class="fas fa-film"></i> Movies</a>
    <a href="bookings.php"><i class="fas fa-ticket-alt"></i> Bookings</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="container">
    <button onclick="history.back()" class="btn btn-secondary mb-4">
        <i class="fas fa-arrow-left me-2"></i> Back
    </button>

    <h2 class="mb-4">Edit Profile</h2>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">

        <div class="mb-3">
            <label for="emri" class="form-label">Name</label>
            <input type="text" name="emri" id="emri" class="form-control" value="<?= htmlspecialchars($data['emri']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($data['username']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update</button>
        <a href="user_dashboard.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

<?php include_once 'footer.php'; ?>
