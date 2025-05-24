<?php
include_once "config.php";
include_once "header.php";

if (!isset($_GET['id'])) {
  echo "No movie selected.";
  exit;
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
?>

<style>
  body {
    background-color: black;
    color: white;
    text-align: center;
  }
  .video-wrapper {
    max-width: 900px;
    margin: 50px auto;
    position: relative;
  }
  video {
    width: 100%;
    border: 2px solid red;
    border-radius: 12px;
  }
  h1 {
    margin-top: 20px;
  }
  .share-btn {
    position: absolute;
    top: -40px;
    right: 0;
    background: red;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 999px;
    cursor: pointer;
    font-weight: bold;
  }
</style>

<div class="video-wrapper">
  <h1><?php echo htmlspecialchars($movie['movie_name']); ?></h1>


  <video controls poster="<?php echo $movie['movie_image']; ?>">
    <source src="<?php echo $movie['movie_url']; ?>" type="video/mp4">
    Your browser does not support the video tag.
  </video>
</div>

<?php include_once "footer.php"; ?>
