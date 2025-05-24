<?php
session_start();
include_once "config.php";
include_once "header.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if user is admin
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    // Admin: get all bookings
    $sql = "SELECT bookings.id, users.username, movies.movie_name, bookings.nr_tickets, bookings.date, bookings.time 
            FROM bookings 
            INNER JOIN users ON bookings.user_id = users.id 
            INNER JOIN movies ON bookings.movie_id = movies.id";
    $getBookings = $conn->prepare($sql);
    $getBookings->execute();
    $bookings = $getBookings->fetchAll();
} else {
    // Regular user: get only their bookings
    $sql = "SELECT bookings.id, users.username, movies.movie_name, bookings.nr_tickets, bookings.date, bookings.time 
            FROM bookings 
            INNER JOIN users ON bookings.user_id = users.id 
            INNER JOIN movies ON bookings.movie_id = movies.id
            WHERE users.username = :username";
    $getBookings = $conn->prepare($sql);
    $getBookings->bindParam(':username', $_SESSION['username']);
    $getBookings->execute();
    $bookings = $getBookings->fetchAll();
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

    .table th, .table td {
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

<!-- Transparent Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: transparent; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-white" href="#">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link text-white" href="movies.php">Movies</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active text-white" href="bookings.php">Bookings</a>
        </li>
      </ul>
    </div>

    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="<?= isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : 'img/default.png' ?>" width="30" height="30" class="rounded-circle me-2">
          <span><?= $_SESSION['username'] ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="user_dashboard.php  ">Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<!-- Page Content -->
<div class="container mt-5">
    <h1 class="mb-4">Bookings</h1>
    <a href="addBooking.php" class="btn btn-success mb-4">Add New Booking</a>
    <div class="table-responsive">
        <table class="table table-bordered table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Movie</th>
                    <th>Number of Tickets</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= $booking['id'] ?></td>
                        <td><?= htmlspecialchars($booking['username']) ?></td>
                        <td><?= htmlspecialchars($booking['movie_name']) ?></td>
                        <td><?= htmlspecialchars($booking['nr_tickets']) ?></td>
                        <td><?= htmlspecialchars($booking['date']) ?></td>
                        <td><?= htmlspecialchars($booking['time']) ?></td>
                        <td>
                            <a href="deleteBooking.php?id=<?= $booking['id'] ?>" class="text-danger">Delete</a> | 
                            <a href="editBooking.php?id=<?= $booking['id'] ?>" class="text-info">Update</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once "footer.php"; ?>
