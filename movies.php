<?php
session_start(); // Must be first before any output
include_once "config.php";
include_once "header.php";
include_once "navbar.php";

// Get filter param from URL
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Modify SQL based on filter
if ($filter === 'movie') {
  $sql = "SELECT * FROM movies WHERE type = 'Movie'";
} elseif ($filter === 'serial') {
  $sql = "SELECT * FROM movies WHERE type = 'Serial'";
} else {
  $sql = "SELECT * FROM movies";
}

$getMovies = $conn->prepare($sql);
$getMovies->execute();
$movies = $getMovies->fetchAll();

$ratings = $conn->query("SELECT movie_id, AVG(rating) AS avg_rating FROM rating GROUP BY movie_id")->fetchAll(PDO::FETCH_KEY_PAIR);

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
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
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

  .movie-year {
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


<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>🎬 Movie Management</h2>
    <div class="d-flex align-items-center gap-2">
      <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
        <a href="addMovie.php" class="btn btn-primary">Add New Movie</a>
      <?php endif; ?>

      <form id="filterForm" method="GET" class="mb-0">
        <select name="filter" class="form-select" onchange="document.getElementById('filterForm').submit()">
          <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>All</option>
          <option value="movie" <?= $filter === 'movie' ? 'selected' : '' ?>>Movies</option>
          <option value="serial" <?= $filter === 'serial' ? 'selected' : '' ?>>Serials</option>
        </select>
      </form>
    </div>
  </div>

  <div class="row g-4">
    <?php foreach ($movies as $movie): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="movie-card">
          <?php if ($movie['movie_image'] && file_exists($movie['movie_image'])): ?>
            <a href="description_movie.php?id=<?= $movie['id']; ?>" class="movie-img-link">
              <img src="<?= htmlspecialchars($movie['movie_image']); ?>" alt="<?= htmlspecialchars($movie['movie_name']) . ' Poster'; ?>" class="movie-img">
            </a>
          <?php else: ?>
            <div style="height: 300px; background-color: #333;" class="d-flex align-items-center justify-content-center text-muted">No Image</div>
          <?php endif; ?>
          <div class="movie-details">
            <div class="movie-title"><?= htmlspecialchars($movie['movie_name']); ?></div>
            <div class="movie-type"><?= htmlspecialchars($movie['type'] ?? 'Movie') ?></div>
            <?php
                  $avg = isset($ratings[$movie['id']]) ? number_format($ratings[$movie['id']], 1) : 'N/A';
            ?>
                  <div class="movie-rating">⭐ <?= $avg ?> / 5</div>

            <div class="movie-views">👁️ Views: <?= (int)$movie['views']; ?></div>
            <div class="movie-year">Year: <?= (int)$movie['year']; ?></div>
            <div class="movie-description"><?= htmlspecialchars($movie['movie_desc']); ?></div>
            <div class="movie-actions mt-2">
              <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                <a href="movieEdit.php?id=<?= $movie['id'] ?>" class="btn-update">Update</a> |
                <a href="deleteMovie.php?id=<?= $movie['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include_once "footer.php"; ?>