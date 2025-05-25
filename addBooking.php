<?php
session_start();
include_once "config.php";
include_once "header.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $movie_id = $_POST['movie_id'];
    $nr_tickets = $_POST['nr_tickets'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "INSERT INTO bookings (user_id, movie_id, nr_tickets, date, time)
            VALUES (:user_id, :movie_id, :nr_tickets, :date, :time)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':movie_id', $movie_id);
    $stmt->bindParam(':nr_tickets', $nr_tickets);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':time', $time);

    if ($stmt->execute()) {
        header("Location: bookings.php");
        exit;
    } else {
        echo "Error adding the booking.";
    }
}

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    $usersStmt = $conn->prepare("SELECT id, username FROM users");
    $usersStmt->execute();
    $users = $usersStmt->fetchAll();
} else {
    $usersStmt = $conn->prepare("SELECT id, username FROM users WHERE username = :username");
    $usersStmt->bindParam(':username', $_SESSION['username']);
    $usersStmt->execute();
    $users = $usersStmt->fetchAll();
}

$moviesStmt = $conn->prepare("SELECT id, movie_name, cinema FROM movies");
$moviesStmt->execute();
$allMovies = $moviesStmt->fetchAll();

$cinemaMovies = [
    'Cineplex' => [],
    'Cinestar' => []
];
foreach ($allMovies as $movie) {
    $cinema = $movie['cinema'];
    if (isset($cinemaMovies[$cinema])) {
        $cinemaMovies[$cinema][] = $movie;
    }
}
?>

<style>
    body {
        background-color: #0e0e0e;
        color: #f1f1f1;
        font-family: 'Segoe UI', sans-serif;
    }

    .booking-container {
        max-width: 600px;
        margin: 60px auto;
        background-color: #1a1a1a;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(255, 0, 0, 0.15);
    }

    .booking-container h2 {
        font-size: 26px;
        text-align: center;
        margin-bottom: 25px;
        color: #fff;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 6px;
        color: #ccc;
    }

    .form-control,
    .form-select {
        background-color: #2a2a2a;
        border: 1px solid #444;
        color: #fff;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #ff3b3f;
        box-shadow: none;
    }

    .btn-primary {
        background-color: #ff3b3f;
        border: none;
        font-weight: bold;
        padding: 12px;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #cc2f33;
    }

    .form-group {
        margin-bottom: 20px;
    }
</style>

<div class="booking-container">
    <h2>➕ Add New Booking</h2>
    <form method="POST" action="addBooking.php">
        <div class="form-group">
            <label for="user_id" class="form-label">User</label>
            <select class="form-select" id="user_id" name="user_id" required>
                <option value="">Select User</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id']; ?>"><?= htmlspecialchars($user['username']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="cinema" class="form-label">Cinema</label>
            <select class="form-select" id="cinema" required onchange="filterMovies()">
                <option value="">Select Cinema</option>
                <option value="Cineplex">Cineplex</option>
                <option value="Cinestar">Cinestar</option>
            </select>
        </div>

        <div class="form-group">
            <label for="movie_id" class="form-label">Movie</label>
            <select class="form-select" id="movie_id" name="movie_id" required>
                <option value="">Select Movie</option>
                <?php foreach ($cinemaMovies as $cinema => $movies): ?>
                    <?php foreach ($movies as $movie): ?>
                        <option value="<?= $movie['id'] ?>" data-cinema="<?= $cinema ?>">
                            <?= htmlspecialchars($movie['movie_name']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="nr_tickets" class="form-label">Number of Tickets</label>
            <input type="number" class="form-control" id="nr_tickets" name="nr_tickets" min="1" required>
        </div>

        <div class="form-group">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <div class="form-group">
            <label for="time" class="form-label">Time</label>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add Booking</button>
    </form>
</div>

<script>
    function filterMovies() {
        const selectedCinema = document.getElementById("cinema").value;
        const movieSelect = document.getElementById("movie_id");
        const options = movieSelect.querySelectorAll("option");

        options.forEach(option => {
            if (!option.value) return; // Skip placeholder
            option.style.display = option.dataset.cinema === selectedCinema ? "block" : "none";
        });

        movieSelect.value = "";
    }
</script>

<?php include_once "footer.php"; ?>
