<!-- <?php
session_start();
include_once "config.php";
include_once "header.php";

// Fetch movies/serials to stream from DB (example)
try {
    $stmt = $conn->query("SELECT * FROM movies ORDER BY id DESC LIMIT 10");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $movies = [];
    // You can log or handle errors here
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Stream Movies & Serials</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #000;
      color: #fff;
    }
    .navbar-nav {
      margin: 0 auto;
    }
    .navbar-dark .nav-link {
      color: #fff;
      margin: 0 15px;
    }
    .stream-container {
      margin-top: 40px;
      margin-bottom: 60px;
    }
    .video-card {
      background-color: #1a1a1a;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 30px;
    }
    .video-title {
      font-weight: 700;
      margin-bottom: 10px;
      font-size: 1.3rem;
    }
    .video-meta {
      font-size: 0.9rem;
      color: #ccc;
      margin-bottom: 15px;
    }
    video {
      width: 100%;
      border-radius: 8px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-white" href="#">User Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Centered Navigation Links -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" id="cinemaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Cinemas
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="cinemaDropdown">
            <li><a class="dropdown-item" href="cinestar.php">Cinestar</a></li>
            <li><a class="dropdown-item" href="cineplex.php">Cineplex</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link text-white" href="movies.php">Movies</a></li>
        <li class="nav-item"><a class="nav-link active text-white" href="stream.php">Stream</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="events.php">Events</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="play.php">Play</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="activities.php">Activities</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="bookings.php">Bookings</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container stream-container">
  <h1 class="mb-4 text-center">Stream Movies & Serials</h1>

  <?php if (empty($movies)) : ?>
    <p class="text-center text-muted">No movies or serials available for streaming right now.</p>
  <?php else: ?>
    <div class="row">
      <?php foreach ($movies as $movie): ?>
        <div class="col-md-6 col-lg-4">
          <div class="video-card">
            <img src="<?= htmlspecialchars($movie['movie_image']) ?>" alt="<?= htmlspecialchars($movie['movie_name']) ?>" class="img-fluid rounded mb-3" />
            <div class="video-title"><?= htmlspecialchars($movie['movie_name']) ?></div>
            <div class="video-meta">
              <?= htmlspecialchars($movie['movie_quality']) ?> |
              Rating: <?= htmlspecialchars($movie['movie_rating']) ?>/10 |
              Year: <?= htmlspecialchars($movie['year']) ?> |
              Type: <?= htmlspecialchars($movie['type']) ?>
            </div>

            <?php if (!empty($movie['movie_url'])): ?>
              <?php if (filter_var($movie['movie_url'], FILTER_VALIDATE_URL)): ?>
                <!-- External URL - embed video player with iframe if YouTube or similar, else link -->
                <a href="<?= htmlspecialchars($movie['movie_url']) ?>" target="_blank" class="btn btn-outline-light btn-sm w-100">Watch Online</a>
              <?php else: ?>
                <!-- Local uploaded video -->
                <video controls preload="metadata" poster="<?= htmlspecialchars($movie['movie_image']) ?>">
                  <source src="<?= htmlspecialchars($movie['movie_url']) ?>" type="video/mp4" />
                  Your browser does not support the video tag.
                </video>
              <?php endif; ?>
            <?php else: ?>
              <p class="text-muted">No video available</p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php include_once "footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> -->
