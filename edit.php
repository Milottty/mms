<?php
session_start();
include_once 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: user_dashboard.php"); // or dashboard.php depending on your flow
    exit();
}

// Fetch user info from DB
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user exists and user owns this profile
if (!$data || $data['username'] !== $_SESSION['username']) {
    header("Location: user_dashboard.php");
    exit();
}

include_once 'header.php';
?>

<div class="container mt-5">
    <h2>Edit Profile</h2>
    <form action="update.php" method="POST" class="mt-3">
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
