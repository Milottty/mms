<?php

include_once "config.php";
include_once "header.php";

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get current logged-in user info
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // If user not found (shouldn't happen), logout
    header("Location: logout.php");
    exit();
}
?>

<style>
    body {
        background-color: #121212;
        color: white;
    }

    .navbar-dark .navbar-nav .nav-link {
        color: rgba(255, 255, 255, 0.85);
    }

    .navbar-dark .navbar-nav .nav-link:hover {
        color: #fff;
    }

    .table {
        background-color: #1e1e1e;
        color: white;
    }

    .table th,
    .table td {
        color: white;
        vertical-align: middle;
    }

    .dropdown-menu-dark {
        background-color: #333;
    }

    .dropdown-menu-dark .dropdown-item:hover {
        background-color: #dc3545;
    }
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: transparent; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-white" href="#">User Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active text-white" href="user_dashboard.php">My Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="movies.php">Movies</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="bookings.php">Bookings</a>
        </li>
      </ul>
    </div>

    <!-- Right-side User Dropdown -->
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="<?= isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : 'img/default.png' ?>" width="30" height="30" class="rounded-circle me-2" alt="Profile">
          <span><?= htmlspecialchars($_SESSION['username']) ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="settings.php">Settings</a></li>
          <li><a class="dropdown-item" href="profile.php">Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<!-- Page Content -->
<div class="container mt-5">
    <h1 class="mb-4">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>
    <div class="table-responsive">
        <table class="table table-bordered table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['emri']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td>
                         <a href="edit.php?id=<?= $user['id'] ?>" class="text-info">Update</a> |
                        <a href="delete.php?id=<?= $user['id'] ?>" class="text-danger" onclick="return confirm('Are you sure you want to delete your account?')">Delete</a>
                        </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include_once "footer.php"; ?>
