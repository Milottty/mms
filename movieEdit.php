<?php
include_once "config.php";
include_once "header.php";
session_start();

// Check if movie ID is set
if (!isset($_GET['id'])) {
    echo "Invalid movie ID!";
    exit;
}

$movieId = $_GET['id'];
$sql = "SELECT * FROM movies WHERE id = :id";
$getMovie = $conn->prepare($sql);
$getMovie->bindParam(':id', $movieId);
$getMovie->execute();
$movie = $getMovie->fetch();

if (!$movie) {
    echo "Movie not found!";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movie_name = $_POST['movie_name'];
    $movie_desc = $_POST['movie_desc'];
    $movie_quality = $_POST['movie_quality'];
    $movie_rating = $_POST['movie_rating'];
    $type = $_POST['type'];

    // Optional: update file if uploaded
   if (!empty($_POST['movie_url'])) {
    $movie_url = $_POST['movie_url'];
} else {
    $movie_url = $movie['movie_url'];
}

    $updateSql = "UPDATE movies SET movie_name = :movie_name, movie_desc = :movie_desc, movie_quality = :movie_quality, movie_rating = :movie_rating, movie_url = :movie_url, type = :type WHERE id = :id";
    $updateMovie = $conn->prepare($updateSql);
    $updateMovie->bindParam(':movie_name', $movie_name);
    $updateMovie->bindParam(':movie_desc', $movie_desc);
    $updateMovie->bindParam(':movie_quality', $movie_quality);
    $updateMovie->bindParam(':movie_rating', $movie_rating);
    $updateMovie->bindParam(':movie_url', $movie_url);
    $updateMovie->bindParam(':type', $type);
    $updateMovie->bindParam(':id', $movieId);

    if ($updateMovie->execute()) {
        header("Location: movies.php");
        exit;
    } else {
        echo "Failed to update the movie.";
    }
}

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
    background-color: #121212;
    color: #fff;
  }
  .form-container {
    max-width: 700px;
    margin: 50px auto;
    background-color: #1e1e1e;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.5);
  }
  label {
    font-weight: bold;
  }
  .form-control, .form-select {
    background-color: #2c2c2c;
    color: #fff;
    border: 1px solid #444;
  }
  .form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: none;
    background-color: #2c2c2c;
  }
  .btn-primary {
    background-color: #0d6efd;
    border: none;
  }
  h3 {
    color: #fff;
    margin-bottom: 20px;
  }
</style>

<div class="container form-container">
  <h3>Edit Movie</h3>
  <form method="POST" enctype="multipart/form-data" action="movieEdit.php?id=<?php echo $movie['id']; ?>">
    <div class="mb-3">
      <label for="movie_name" class="form-label">Movie Name</label>
      <input type="text" class="form-control" id="movie_name" name="movie_name" value="<?php echo htmlspecialchars($movie['movie_name']); ?>" required>
    </div>

    <div class="mb-3">
      <label for="movie_desc" class="form-label">Movie Description</label>
      <textarea class="form-control" id="movie_desc" name="movie_desc" required><?php echo htmlspecialchars($movie['movie_desc']); ?></textarea>
    </div>

    <div class="mb-3">
      <label for="type" class="form-label">Type</label>
      <select class="form-select" id="type" name="type" required>
        <option value="movie" <?php if ($movie['type'] === 'movie') echo 'selected'; ?>>Movie</option>
        <option value="serial" <?php if ($movie['type'] === 'serial') echo 'selected'; ?>>Serial</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="movie_quality" class="form-label">Quality</label>
      <select class="form-select" id="movie_quality" name="movie_quality" required>
        <option value="HD" <?php if ($movie['movie_quality'] == 'HD') echo 'selected'; ?>>HD</option>
        <option value="Full HD" <?php if ($movie['movie_quality'] == 'Full HD') echo 'selected'; ?>>Full HD</option>
        <option value="4K" <?php if ($movie['movie_quality'] == '4K') echo 'selected'; ?>>4K</option>
        <option value="SD" <?php if ($movie['movie_quality'] == 'SD') echo 'selected'; ?>>SD</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="movie_rating" class="form-label">Rating (1-10)</label>
      <input type="number" class="form-control" id="movie_rating" name="movie_rating" value="<?php echo htmlspecialchars($movie['movie_rating']); ?>" required min="1" max="10">
    </div>

    <div class="mb-3">
        <label for="movie_url" class="form-label">Movie Video URL</label>
         <input type="url" class="form-control" id="movie_url" name="movie_url" value="<?php echo htmlspecialchars($movie['movie_url']); ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Update Movie</button>
  </form>
</div>

<?php include_once "footer.php"; ?>
