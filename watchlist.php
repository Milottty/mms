<?php
session_start();
include_once 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['username'];

// Get user ID from users table
$sqlUser = "SELECT id FROM users WHERE username = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->execute([$user]);
$userData = $stmtUser->fetch();

if (!$userData) {
    echo "User not found.";
    exit();
}

$userId = $userData['id'];

// Fetch movies from watchlist for this user
$sql = "SELECT m.* FROM movies m
        JOIN watchlist w ON m.id = w.movie_id
        WHERE w.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$userId]);
$watchedMovies = $stmt->fetchAll();
$ratings = $conn->query("SELECT movie_id, AVG(rating) AS avg_rating FROM rating GROUP BY movie_id")->fetchAll(PDO::FETCH_KEY_PAIR);


?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  body {
    background-color: #121212;
    color: #fff;
    padding: 40px 20px 20px 20px;
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
    height: 250px;
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
  .movie-description {
    font-size: 0.85rem;
    color: #ccc;
    margin-bottom: 10px;
    max-height: 60px;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .btn-update-like {
    color: #0d6efd;
    text-decoration: none;
    padding: 4px 10px;
    border-radius: 5px;
    transition: background-color 0.2s ease;
    display: inline-block;
    font-size: 0.85rem;
  }
  .btn-update-like:hover {
    background-color: #0d6efd;
    color: white;
    text-decoration: none;
  }
  .back-button {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1050;
  }
</style>

<a href="movies.php" class="btn-update-like back-button">← Back to Movies</a>

<div class="container my-5">
  <h2>Your Watchlist 🎥</h2>
  <?php if (count($watchedMovies) > 0): ?>
  <div class="row g-4 mt-3">
    <?php foreach ($watchedMovies as $movie): ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="movie-card">
          <?php if ($movie['movie_image'] && file_exists($movie['movie_image'])): ?>
            <a href="description_movie.php?id=<?php echo $movie['id']; ?>" class="movie-img-link">
              <img src="<?php echo htmlspecialchars($movie['movie_image']); ?>" alt="Movie Poster" class="movie-img">
            </a>
          <?php else: ?>
            <div style="height: 250px; background-color: #333;" class="d-flex align-items-center justify-content-center text-muted">No Image</div>
          <?php endif; ?>
          <div class="movie-details">
            <div class="movie-title"><?php echo htmlspecialchars($movie['movie_name']); ?></div>
            <div class="movie-type"><?= htmlspecialchars($movie['type'] ?? 'Movie') ?></div>
            <?php
                  $avg = isset($ratings[$movie['id']]) ? number_format($ratings[$movie['id']], 1) : 'N/A';
            ?>
                  <div class="movie-rating">⭐ <?= $avg ?> / 5</div>
            <div class="movie-views">👁️ Views: <?php echo (int)$movie['views']; ?></div>
            <div class="movie-description"><?php echo htmlspecialchars($movie['movie_desc']); ?></div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php else: ?>
    <p>You have not watched any movies yet.</p>
  <?php endif; ?>
</div>

<?php include_once "footer.php"; ?>
