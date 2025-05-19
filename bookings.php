<?php
include_once "config.php";
include_once "header.php";

$sql = "SELECT bookings.id, users.username, movies.movie_name, bookings.nr_tickets, bookings.date, bookings.time 
        FROM bookings 
        INNER JOIN users ON bookings.user_id = users.id 
        INNER JOIN movies ON bookings.movie_id = movies.id";
$getBookings = $conn->prepare($sql);
$getBookings->execute();

$bookings = $getBookings->fetchAll();
?>

<div class="d-flex" style="height: 100vh;">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <svg class="bi me-2" width="40" height="70">
                <use xlink:href="#bootstrap"></use>
            </svg>
            <span class="fs-4">Sidebar</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link text-white" aria-current="page">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="dashboard.php"></use>
                    </svg>
                    Users
                </a>
            </li>
            <li>
                <a href="movies.php" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="movies.php"></use>
                    </svg>
                    Movies
                </a>
            </li>
            <li>
                <a href="bookings.php" class="nav-link text-white active" aria-current="page">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="bookings.php"></use>
                    </svg>
                    Booking
                </a>
            </li>
            <li>
                    <a href="logout.php" class="nav-link text-white">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="logout.php"></use>
                        </svg>
                        Logout
                    </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>mdo</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </div>
    <div class="p-5">
    <a href="addBooking.php" class="btn btn-success mb-4">Add New Booking</a>
    <table class="table table-bordered">
            <thead>
                <th>ID</th>
                <th>User</th>
                <th>Movie</th>
                <th>Number of Tickets</th>
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo $booking['id']; ?></td>
                        <td><?php echo htmlspecialchars($booking['username']); ?></td>
                        <td><?php echo htmlspecialchars($booking['movie_name']); ?></td>
                        <td><?php echo htmlspecialchars($booking['nr_tickets']); ?></td>
                        <td><?php echo htmlspecialchars($booking['date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['time']); ?></td>
                        <td>
                            <a href="deleteBooking.php?id=<?php echo $booking['id']; ?>">Delete</a> | 
                            <a href="editBooking.php?id=<?php echo $booking['id']; ?>">Update</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once "footer.php"; ?>
