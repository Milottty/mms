<?php
include_once "config.php";
include_once "header.php";
session_start();

$moviesToShow = 8;
$seed = date('Ymd') . "cinestar"; // Different seed for cinestar

$sql = "SELECT * FROM movies";
$stmt = $conn->prepare($sql);
$stmt->execute();
$allMovies = $stmt->fetchAll(PDO::FETCH_ASSOC);

function seededShuffle(&$array, $seed) {
    srand(crc32($seed));
    for ($i = count($array) - 1; $i > 0; $i--) {
        $j = rand(0, $i);
        $temp = $array[$i];
        $array[$i] = $array[$j];
        $array[$j] = $temp;
    }
    srand(); // reset seed
}

seededShuffle($allMovies, $seed);
$movies = array_slice($allMovies, 0, $moviesToShow);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
    background-color: #121212;
    color: #fff;
  }
  .movie-card {
    background-color: #1e1e1e;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.5);
    transition: transform 0.2s;
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  .movie-card:hover {
    transform: scale(1.03);
  }
  .movie-img-link {
    display: block;
  }
  .movie-img {
    height: 300px;
    object-fit: cover;
    width: 100%;
    display: block;
  }
  .movie-details {
    padding: 15px;
    flex-grow: 1;
  }
  .movie-title {
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 2px;
  }
  .movie-type {
    font-size: 0.85rem;
    color: #bbb;
    margin-bottom: 5px;
  }
  .movie-rating {
    color: #ffc107;
    font-size: 0.9rem;
    margin-bottom: 5px;
  }
  .movie-views {
    font-size: 0.9rem;
    color: #bbb;
    margin-bottom: 5px;
  }
  .movie-year{
    font-size: 0.9rem;
    color: #bbb;
    margin-bottom: 5px;
  }
  .movie-description {
    font-size: 0.85rem;
    color: #ccc;
    margin-bottom: 10px;
    max-height: 60px;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .movie-actions a {
    margin-right: 10px;
    text-decoration: none;
    padding: 6px 12px;
    font-size: 0.9rem;
    border-radius: 5px;
    background-color: #dc3545;
    color: white;
    display: inline-block;
    transition: background-color 0.2s;
  }
  .movie-actions a:hover {
    background-color: #bb2d3b;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: transparent; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold text-white" href="#">User Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" id="cinemaDropdown" role="button" data-bs-toggle="dropdown">
            Cinemas
          </a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="cinestar.php">Cinestar</a></li>
            <li><a class="dropdown-item" href="cineplex.php">Cineplex</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link text-white" href="movies.php">Movies</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="bookings.php">Bookings</a></li>
      </ul>
    </div>

    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="userDropdown" data-bs-toggle="dropdown">
          <img src="<?= isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : 'img/default.png' ?>" width="30" height="30" class="rounded-circle me-2" alt="Profile">
          <span><?= htmlspecialchars($_SESSION['username'] ?? 'Guest') ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
          <li><a class="dropdown-item" href="settings.php">Settings</a></li>
          <li><a class="dropdown-item" href="user_dashboard.php">Profile</a></li>
          <li><a class="dropdown-item" href="watchlist.php">WatchList</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<div class="container my-5">
  <h2 class="mb-4">🎥 Cinestar Featured Movies</h2>
  <div class="row g-4">
    <?php foreach ($movies as $movie): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="movie-card">
          <?php if ($movie['movie_image'] && file_exists($movie['movie_image'])): ?>
            <a href="description_movie.php?id=<?= $movie['id']; ?>" class="movie-img-link">
              <img src="<?= htmlspecialchars($movie['movie_image']); ?>" alt="Movie Poster" class="movie-img">
            </a>
          <?php else: ?>
            <div style="height: 300px; background-color: #333;" class="d-flex align-items-center justify-content-center text-muted">No Image</div>
          <?php endif; ?>
          <div class="movie-details">
            <div class="movie-title"><?= htmlspecialchars($movie['movie_name']); ?></div>
            <div class="movie-type"><?= htmlspecialchars($movie['type'] ?? 'Movie'); ?></div>
            <div class="movie-rating">⭐ <?= htmlspecialchars($movie['movie_rating']); ?>/10</div>
            <div class="movie-year">Year: <?= (int)$movie['year']; ?></div>
            <div class="movie-description"><?= htmlspecialchars($movie['movie_desc']); ?></div>
            <div class="movie-actions mt-2">
              <a href="bookings.php?movie_id=<?= $movie['id']; ?>">Booking</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include_once "footer.php"; ?>