<?php
include_once "config.php";
include_once "header.php";

session_start();

$sql = "SELECT * FROM movies";
$getMovies = $conn->prepare($sql);
$getMovies->execute();
$movies = $getMovies->fetchAll();
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
  }
  .movie-title {
    font-size: 1.1rem;
    font-weight: bold;
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
    padding: 4px 10px;
    font-size: 0.85rem;
    border-radius: 5px;
    transition: background-color 0.2s;
    display: inline-block;
  }
  .btn-update {
    color: #0d6efd;
  }
  .btn-delete {
    color: #dc3545;
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
          <li><a class="dropdown-item" href="user_dashboard.php">Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>🎬 Movie Management</h2>
    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
    <a href="addMovie.php" class="btn btn-primary">Add New Movie</a>
    <?php endif; ?>

  </div>

  <div class="row g-4">
    <?php foreach ($movies as $movie): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="movie-card">
          <?php if ($movie['movie_image'] && file_exists($movie['movie_image'])): ?>
            <a href="description_movie.php?id=<?php echo $movie['id']; ?>" class="movie-img-link">
              <img src="<?php echo htmlspecialchars($movie['movie_image']); ?>" alt="Movie Poster" class="movie-img">
            </a>
          <?php else: ?>
            <div style="height: 300px; background-color: #333;" class="d-flex align-items-center justify-content-center text-muted">No Image</div>
          <?php endif; ?>
          <div class="movie-details">
            <div class="movie-title">
              <?php echo htmlspecialchars($movie['movie_name']); ?> 
            </div>
            <div class="movie-rating">⭐ <?php echo htmlspecialchars($movie['movie_rating']); ?>/10</div>
            <div class="movie-views">👁️ Views: <?php echo (int)$movie['views']; ?></div>
            <div class="movie-description"><?php echo htmlspecialchars($movie['movie_desc']); ?></div>
            <div class="movie-actions mt-2">
              <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
              <a href="movieEdit.php?id=<?= $movie['id'] ?>">Update</a>|   
              <a href="deleteMovie.php?id=<?= $movie['id'] ?>" onclick="return confirm('Are you sure?')"> Delete</a>
            <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include_once "footer.php"; ?>
