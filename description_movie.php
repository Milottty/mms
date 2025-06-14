<?php
session_start();
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
$updateViews = $conn->prepare("UPDATE movies SET views = views + 1 WHERE id = :id");
$updateViews->bindParam(':id', $movie_id, PDO::PARAM_INT);
$updateViews->execute();

// Handle rating POST (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating']) && isset($_SESSION['user'])) {
    $rating = intval($_POST['rating']);
    $user_id = $_SESSION['user']['id'];
    $date = date("Y-m-d");

    $check = $conn->prepare("SELECT * FROM rating WHERE user_id = :user_id AND movie_id = :movie_id");
    $check->execute(['user_id' => $user_id, 'movie_id' => $movie_id]);

    if ($check->rowCount() > 0) {
        $update = $conn->prepare("UPDATE rating SET time = :rating, date = :date WHERE user_id = :user_id AND movie_id = :movie_id");
        $update->execute([
            'rating' => $rating,
            'date' => $date,
            'user_id' => $user_id,
            'movie_id' => $movie_id
        ]);
    } else {
        $insert = $conn->prepare("INSERT INTO rating (user_id, movie_id, time, date) VALUES (:user_id, :movie_id, :rating, :date)");
        $insert->execute([
            'user_id' => $user_id,
            'movie_id' => $movie_id,
            'rating' => $rating,
            'date' => $date
        ]);
    }
    exit;
}

// Get average rating
$avg_stmt = $conn->prepare("SELECT AVG(time) as avg_rating FROM rating WHERE movie_id = :movie_id");
$avg_stmt->execute(['movie_id' => $movie_id]);
$avg_result = $avg_stmt->fetch();
$avg_rating = $avg_result && $avg_result['avg_rating'] ? number_format($avg_result['avg_rating'], 1) : 'N/A';

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

  /* Star rating dropdown container */
 .rating-wrapper {
  position: relative;
  display: inline-block;
  margin-top: 10px;
  z-index: 10;
}

.rating-label {
  cursor: pointer;
  user-select: none;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: #ffc107;
  font-size: 1.1rem;
  padding: 2px 6px;
  background-color: rgba(255, 255, 255, 0.05);
  border-radius: 6px;
  position: relative;
  z-index: 15;
}


  /* Dropdown stars container, hidden by default */
  .stars-dropdown {
    position: absolute;
    top: 28px;
    left: 0;
    background: #2c2c2c;
    border-radius: 8px;
    padding: 6px 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.6);
    display: none;
    z-index: 10;
    white-space: nowrap;
  }

  /* Show dropdown on hover of the wrapper */
.rating-wrapper:hover .stars-dropdown {
  display: inline-block;
}

  /* Stars inside dropdown */
  .stars-dropdown input[type="radio"] {
    display: none;
  }

  .stars-dropdown label {
    font-size: 2rem;
    color: #444;
    cursor: pointer;
    transition: color 0.3s ease;
  }

  /* Highlight stars on hover or checked */
  .stars-dropdown label:hover,
  .stars-dropdown label:hover ~ label,
  .stars-dropdown input[type="radio"]:checked ~ label {
    color: #ffc107;
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
    <div class="movie-type">
      <?= htmlspecialchars($movie['type'] ?? 'Movie') ?>
    </div> <br>
    <?php if (isset($_SESSION['emri'])):
        $user_rating = null;
        ?>
        <div class="rating-wrapper" title="Hover and select stars to rate">
          <div class="rating-label">Rate this movie ★</div>
          <form id="rating-form" method="post" class="stars-dropdown" action="">
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" <?= ($user_rating == $i) ? 'checked' : '' ?>>
                <label for="star<?= $i ?>">★</label>
              <?php endfor; ?>
            </form>
        </div>
      <?php endif;
      
      ?>
    <div class="movie-meta">
      <span>⭐ <?php echo htmlspecialchars($user_rating['rating']); ?>/5</span>
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

<script>
  // Handle star click (rating submission)
  document.querySelectorAll('.stars-dropdown input[name="rating"]').forEach(radio => {
    radio.addEventListener('change', function () {
      const formData = new FormData();
      formData.append('rating', this.value);

      fetch("", {
        method: 'POST',
        body: formData
      }).then(res => {
        if (res.ok) {
          alert("Rating submitted!");
          location.reload();  // Reload to show updated average
        } else {
          alert("Failed to submit rating.");
        }
      }).catch(() => alert("Network error."));
    });
  });
</script>

<?php include_once "footer.php"; ?>
