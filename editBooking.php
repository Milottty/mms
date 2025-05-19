<?php
include_once "config.php";
include_once "header.php";

// Fetch movies
$moviesQuery = "SELECT id, movie_name FROM movies";
$moviesStmt = $conn->prepare($moviesQuery);
$moviesStmt->execute();
$movies = $moviesStmt->fetchAll();

// Fetch users
$usersQuery = "SELECT id, username FROM users";
$usersStmt = $conn->prepare($usersQuery);
$usersStmt->execute();
$users = $usersStmt->fetchAll();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM bookings WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $booking = $stmt->fetch();

    if (!$booking) {
        echo "Booking not found.";
        exit;
    }

    if (isset($_POST['submit'])) {
        $user_id = $_POST['user_id'];
        $movie_id = $_POST['movie_id'];
        $nr_tickets = $_POST['nr_tickets'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        $updateQuery = "UPDATE bookings SET user_id = :user_id, movie_id = :movie_id, nr_tickets = :nr_tickets, date = :date, time = :time WHERE id = :id";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bindParam(':user_id', $user_id);
        $updateStmt->bindParam(':movie_id', $movie_id);
        $updateStmt->bindParam(':nr_tickets', $nr_tickets);
        $updateStmt->bindParam(':date', $date);
        $updateStmt->bindParam(':time', $time);
        $updateStmt->bindParam(':id', $id);

        if ($updateStmt->execute()) {
            echo "Booking updated successfully.";
            header("Location: bookings.php");
            exit;
        } else {
            echo "Error updating booking.";
        }
    }
} else {
    echo "Invalid booking ID.";
    exit;
}
?>

<div class="container">
    <h2 class="mt-5">Edit Booking</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select class="form-select" id="user_id" name="user_id" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id']; ?>" <?= $user['id'] == $booking['user_id'] ? 'selected' : ''; ?>>
                        <?= $user['username']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="movie_id" class="form-label">Movie</label>
            <select class="form-select" id="movie_id" name="movie_id" required>
                <?php foreach ($movies as $movie): ?>
                    <option value="<?= $movie['id']; ?>" <?= $movie['id'] == $booking['movie_id'] ? 'selected' : ''; ?>>
                        <?= $movie['movie_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nr_tickets" class="form-label">Number of Tickets</label>
            <input type="number" class="form-control" id="nr_tickets" name="nr_tickets" min="1" value="<?= $booking['nr_tickets']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="<?= $booking['date']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" class="form-control" id="time" name="time" value="<?= $booking['time']; ?>" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update Booking</button>
    </form>
</div>

<?php include_once "footer.php"; ?>
