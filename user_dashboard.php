<?php
include_once "config.php";
include_once "header.php";

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: logout.php");
    exit();
}
?>

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

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

    .content {
        margin-left: 240px;
        padding: 40px;
        background-color: #0d0d0d;
        min-height: 100vh;
    }

    .card {
        background-color: #1a1a1a;
        border: 1px solid #333;
        border-radius: 10px;
        padding: 25px;
        color: #e0e0e0;
    }

    .card h4 {
        color: #fff;
    }

    .table {
        background-color: #1a1a1a;
        color: #e0e0e0;
        border-collapse: collapse;
        width: 100%;
    }

    .table th {
        background-color: #222;
        color: #fff;
        font-weight: 600;
        border: 1px solid #333;
        padding: 12px 15px;
    }

    .table td {
        background-color: #1a1a1a;
        color: #e0e0e0;
        border: 1px solid #333;
        padding: 12px 15px;
    }

    .btn-link {
        color: #1dbf73;
        text-decoration: none;
    }

    .btn-link:hover {
        color: #17a864;
        text-decoration: underline;
    }

    .btn-link.text-danger:hover {
        color: #e3342f;
    }

    .btn-outline-light {
        border: 1px solid #555;
        color: #ccc;
        background-color: transparent;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        transition: 0.2s;
    }

    .btn-outline-light:hover {
        background-color: #1dbf73;
        color: #fff;
        border-color: #1dbf73;
    }

    .rounded-circle {
        object-fit: cover;
    }
</style>

<div class="sidebar">
    <a href="dashboard.php" class="active"><i class="fas fa-user"></i> Profile</a>
    <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
    <a href="movies.php"><i class="fas fa-film"></i> Movies</a>
    <a href="bookings.php"><i class="fas fa-ticket-alt"></i> Bookings</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="content">
    <button onclick="Location: movies.php;" class="btn-outline-light mb-4">
        <i class="fas fa-arrow-left me-2"></i> Back
    </button>

    <h2 class="mb-4">Profile Overview</h2>
    <div class="card">
        <div class="d-flex align-items-center mb-3">
            <img src="<?= htmlspecialchars($_SESSION['profile_image']) ?>" width="60" height="60" class="rounded-circle me-3" alt="Profile" />
            <h4 class="mb-0"><?= htmlspecialchars($user['emri']) ?> (<?= htmlspecialchars($user['username']) ?>)</h4>
        </div>

        <table class="table">
            <tr>
                <th>ID:</th>
                <td><?= htmlspecialchars($user['id']) ?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><?= htmlspecialchars($user['email']) ?></td>
            </tr>
            <tr>
                <th>Username:</th>
                <td><?= htmlspecialchars($user['username']) ?></td>
            </tr>
        </table>

        <div class="mt-3">
            <a href="edit.php?id=<?= $user['id'] ?>" class="btn-link">Update Info</a> |
            <a href="delete.php?id=<?= $user['id'] ?>" class="btn-link text-danger" onclick="return confirm('Are you sure you want to delete your account?')">Delete Account</a>
        </div>
    </div>
</div>

<?php include_once "footer.php"; ?>
