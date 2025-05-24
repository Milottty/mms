<?php
session_start(); // Make sure session is started
include_once "config.php";
include_once "header.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    // Get data from the form
    $user_id = $_POST['user_id'];
    $movie_id = $_POST['movie_id'];
    $nr_tickets = $_POST['nr_tickets'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Prepare and execute the SQL query
    $sql = "INSERT INTO bookings (user_id, movie_id, nr_tickets, date, time) VALUES (:user_id, :movie_id, :nr_tickets, :date, :time)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':movie_id', $movie_id);
    $stmt->bindParam(':nr_tickets', $nr_tickets);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':time', $time);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect after success
        header("Location: bookings.php");
        exit;
    } else {
        echo "Error adding the booking.";
    }
}

// Fetch movies for the dropdown
$moviesQuery = "SELECT id, movie_name FROM movies";
$moviesStmt = $conn->prepare($moviesQuery);
$moviesStmt->execute();
$movies = $moviesStmt->fetchAll();

// Fetch users depending on role
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    // Admin can select all users
    $usersQuery = "SELECT id, username FROM users";
    $usersStmt = $conn->prepare($usersQuery);
    $usersStmt->execute();
    $users = $usersStmt->fetchAll();
} else {
    // Regular user can only select themselves
    $usersQuery = "SELECT id, username FROM users WHERE username = :username LIMIT 1";
    $usersStmt = $conn->prepare($usersQuery);
    $usersStmt->bindParam(':username', $_SESSION['username']);
    $usersStmt->execute();
    $users = $usersStmt->fetchAll();
}
?>

<div class="container">
    <h2 class="mt-5">Add New Booking</h2>
    <form method="POST" action="addBooking.php">

        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select class="form-select" id="user_id" name="user_id" required>
                <option value="">Select User</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id']; ?>"><?= htmlspecialchars($user['username']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="movie_id" class="form-label">Movie</label>
            <select class="form-select" id="movie_id" name="movie_id" required>
                <option value="">Select Movie</option>
                <?php foreach ($movies as $movie): ?>
                    <option value="<?= $movie['id']; ?>"><?= htmlspecialchars($movie['movie_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nr_tickets" class="form-label">Number of Tickets</label>
            <input type="number" class="form-control" id="nr_tickets" name="nr_tickets" min="1" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add Booking</button>
    </form>
</div>

<?php include_once "footer.php"; ?>
