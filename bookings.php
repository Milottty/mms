<?php
session_start();
include_once "config.php";
include_once "header.php";
include_once "navbar.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
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
