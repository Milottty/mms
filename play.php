<?php
include_once "config.php";
include_once "header.php";
session_start();

if (!isset($_GET['id'])) {
  echo "No movie selected.";
  exit;
}

$id = $_GET['id'];

// Watchlist: add current movie to database if user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $stmtUser = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmtUser->execute([$username]);
    $user = $stmtUser->fetch();

    if ($user) {
        $userId = $user['id'];

        // Check if already in watchlist
        $check = $conn->prepare("SELECT COUNT(*) FROM watchlist WHERE user_id = ? AND movie_id = ?");
        $check->execute([$userId, $id]);
        $alreadyExists = $check->fetchColumn();

        // If not, insert
        if (!$alreadyExists) {
            $add = $conn->prepare("INSERT INTO watchlist (user_id, movie_id) VALUES (?, ?)");
            $add->execute([$userId, $id]);
        }
    }
}


$id = $_GET['id'];
$sql = "SELECT * FROM movies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$movie = $stmt->fetch();

if (!$movie) {
  echo "Movie not found.";
  exit;
}

// *** WATCHLIST ADDITION ***
// Initialize watchlist array if not set
if (!isset($_SESSION['watchlist'])) {
    $_SESSION['watchlist'] = [];
}
// Add current movie id if not already in the list
if (!in_array($id, $_SESSION['watchlist'])) {
    $_SESSION['watchlist'][] = $id;
}
// *** END WATCHLIST ADDITION ***

// ✅ YouTube link check function
function isYouTubeUrl($url) {
  return preg_match('/(youtube\.com|youtu\.be)/i', $url);
}

// Auto-increment views
$conn->prepare("UPDATE movies SET views = views + 1 WHERE id = ?")->execute([$id]);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  body {
    background-color: black;
    color: white;
    text-align: center;
    padding-top: 20px;
  }
  .video-wrapper {
    max-width: 960px;
    margin: 0 auto;
    position: relative;
  }
  video {
    width: 100%;
    border: 2px solid red;
    border-radius: 12px;
  }
  h1 {
    margin: 20px 0 10px;
    font-size: 2rem;
  }
  .movie-info {
    color: #aaa;
    font-size: 0.95rem;
    margin-bottom: 15px;
  }
  .back-button {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1050;
  }
</style>

<a href="movies.php" class="btn btn-danger back-button">← Back to Movies</a>

<div class="video-wrapper">
  <h1><?php echo htmlspecialchars($movie['movie_name']); ?></h1>
  <div class="movie-info">
    <?php echo ucfirst(htmlspecialchars($movie['type'])); ?> | <?php echo htmlspecialchars($movie['movie_quality']); ?> | 
    Rating: <?php echo htmlspecialchars($movie['movie_rating']); ?>/10 | Views: <?php echo (int)$movie['views']; ?>
  </div>

  <?php if (!empty($movie['movie_url'])): ?>
    <?php if (isYouTubeUrl($movie['movie_url'])): ?>
      <?php
        // Convert YouTube URL to embed format
        if (strpos($movie['movie_url'], 'youtu.be') !== false) {
            $videoId = basename(parse_url($movie['movie_url'], PHP_URL_PATH));
        } else {
            parse_str(parse_url($movie['movie_url'], PHP_URL_QUERY), $ytParams);
            $videoId = $ytParams['v'] ?? '';
        }
        $embedUrl = "https://www.youtube.com/embed/" . htmlspecialchars($videoId);
      ?>
      <div class="ratio ratio-16x9">
        <iframe src="<?php echo $embedUrl; ?>" frameborder="0" allowfullscreen></iframe>
      </div>
    <?php elseif (file_exists($movie['movie_url'])): ?>
      <video controls poster="<?php echo htmlspecialchars($movie['movie_image']); ?>">
        <source src="<?php echo htmlspecialchars($movie['movie_url']); ?>" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    <?php else: ?>
      <p class="text-danger mt-4">⚠️ Video file not found or not uploaded.</p>
    <?php endif; ?>
  <?php endif; ?>
</div>

<?php include_once "footer.php"; ?>
