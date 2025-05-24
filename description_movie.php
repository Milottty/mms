<?php
include_once "config.php";
include_once "header.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='alert alert-danger'>Invalid movie ID.</div>";
    exit;
}

$movie_id = (int)$_GET['id'];

$sql = "SELECT * FROM movies WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $movie_id, PDO::PARAM_INT);
$stmt->execute();

$movie = $stmt->fetch();

if (!$movie) {
    echo "<div class='alert alert-warning'>Movie not found.</div>";
    exit;
}

$year = isset($movie['year']) && $movie['year'] > 0 ? $movie['year'] : 'N/A';
$views = isset($movie['views']) ? (int)$movie['views'] : 0;
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
    background-color: #121212;
    color: #fff;
    min-height: 100vh;
  }
  .movie-container {
    max-width: 900px;
    margin: 50px auto;
    background-color: #1e1e1e;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,0,0,0.7);
    display: flex;
    gap: 30px;
    padding: 30px;
  }
  .movie-poster {
    flex-shrink: 0;
    width: 300px;
    border-radius: 12px;
    box-shadow: 0 0 12px rgba(255,255,255,0.15);
  }
  .movie-poster img {
    width: 100%;
    border-radius: 12px;
    display: block;
  }

  .movie-details {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
  }
  .movie-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 8px;
  }
  .movie-meta {
    font-size: 0.95rem;
    color: #ccc;
    margin-bottom: 20px;
  }
  .movie-meta span {
    margin-right: 15px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .movie-description {
    font-size: 1rem;
    line-height: 1.5;
    color: #ddd;
    white-space: pre-wrap;
    margin-bottom: 20px;
  }

  /* Play button styled as before (red color) and placed below description */
  .play-button {
    align-self: start;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: transparent;
    border: 2px solid #dc3545;
    color: #dc3545;
    font-weight: 700;
    font-size: 1.1rem;
    padding: 10px 28px;
    border-radius: 30px;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s ease, color 0.3s ease;
    box-shadow: 0 3px 10px rgba(220, 53, 69, 0.6);
  }
  .play-button:hover {
    background-color: #dc3545;
    color: white;
  }
  .play-button svg {
    width: 20px;
    height: 20px;
    fill: currentColor;
  }
</style>

<div class="movie-container">
  <div class="movie-poster">
    <?php if ($movie['movie_image'] && file_exists($movie['movie_image'])): ?>
      <img src="<?php echo htmlspecialchars($movie['movie_image']); ?>" alt="Movie Poster">
    <?php else: ?>
      <div style="height: 450px; background-color: #333; display:flex; align-items:center; justify-content:center; border-radius:12px; color:#777;">
        No Image
      </div>
    <?php endif; ?>
  </div>
  <div class="movie-details">
    <h1 class="movie-title">
      <?php echo htmlspecialchars($movie['movie_name']); ?> (<?php echo $year; ?>)
    </h1>
    <div class="movie-meta">
      <span>⭐ <?php echo htmlspecialchars($movie['movie_rating']); ?>/10</span>
      <span>📺 <?php echo htmlspecialchars($movie['movie_quality']); ?></span>
      <span>👁️ <?php echo $views; ?> views</span>
    </div>
    <div class="movie-description"><?php echo nl2br(htmlspecialchars($movie['movie_desc'])); ?></div>
    <a href="play.php?id=<?php echo $movie_id; ?>" class="play-button" title="Play Movie">
      <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
        <path d="M8 5v14l11-7z"/>
      </svg>
      Play
    </a>
  </div>
</div>

<?php include_once "footer.php"; ?>
