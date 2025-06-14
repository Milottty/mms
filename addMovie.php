<?php
session_start();
include_once "config.php";
include_once "header.php";

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die('<div class="alert alert-danger">Unauthorized access</div>');
}

if (isset($_POST['submit'])) {
    // Trim inputs to avoid whitespace issues
    $movie_name = trim($_POST['movie_name'] ?? '');
    $movie_desc = trim($_POST['movie_desc'] ?? '');
    $movie_quality = trim($_POST['movie_quality'] ?? '');
    $movie_rating = trim($_POST['movie_rating'] ?? '');
    $movie_year = trim($_POST['movie_year'] ?? '');
    $movie_type = trim($_POST['movie_type'] ?? '');

    // Basic validation
    if (!$movie_name || !$movie_desc || !$movie_quality || !$movie_rating || !$movie_year || !$movie_type) {
        echo "<div class='alert alert-danger'>Please fill all required fields.</div>";
        exit;
    }

    $random_views = rand(0, 10000000);

    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle poster image upload (required)
    if (isset($_FILES['movie_image']) && $_FILES['movie_image']['error'] === UPLOAD_ERR_OK) {
        // Sanitize file name to avoid issues
        $fileName = basename($_FILES['movie_image']['name']);
        $fileName = preg_replace("/[^A-Za-z0-9_\-\.]/", '_', $fileName);
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES['movie_image']['tmp_name'], $filePath)) {
            echo "<div class='alert alert-danger'>Failed to upload the image.</div>";
            exit;
        }
    } else {
        echo "<div class='alert alert-warning'>Please select a valid image file.</div>";
        exit;
    }

    // Handle movie video upload OR URL input
    $movie_url = null;

    if (isset($_FILES['movie_url']) && $_FILES['movie_url']['error'] === UPLOAD_ERR_OK) {
        $videoName = basename($_FILES['movie_url']['name']);
        $videoName = preg_replace("/[^A-Za-z0-9_\-\.]/", '_', $videoName);
        $videoExt = strtolower(pathinfo($videoName, PATHINFO_EXTENSION));
        $allowedExts = ['mp4', 'mkv', 'avi', 'mov'];

        if (in_array($videoExt, $allowedExts)) {
            $videoPath = $uploadDir . $videoName;
            if (move_uploaded_file($_FILES['movie_url']['tmp_name'], $videoPath)) {
                $movie_url = $videoPath;
            } else {
                echo "<div class='alert alert-danger'>Failed to upload the movie video.</div>";
                exit;
            }
        } else {
            echo "<div class='alert alert-warning'>Unsupported video format. Allowed: mp4, mkv, avi, mov.</div>";
            exit;
        }
    } else {
        // No file uploaded, check if URL was provided
        if (!empty($_POST['movie_url_text'])) {
            $movie_url = filter_var($_POST['movie_url_text'], FILTER_VALIDATE_URL);
            if (!$movie_url) {
                echo "<div class='alert alert-warning'>Invalid movie URL provided.</div>";
                exit;
            }
        } else {
            echo "<div class='alert alert-warning'>Please upload a movie video file or provide a valid URL.</div>";
            exit;
        }
    }

    // Prepare and execute DB insert
    $sql = "INSERT INTO movies (movie_name, movie_desc, movie_quality, movie_rating, movie_image, year, views, type, movie_url) 
            VALUES (:movie_name, :movie_desc, :movie_quality, :movie_rating, :movie_image, :year, :views, :type, :movie_url)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':movie_name', $movie_name);
    $stmt->bindParam(':movie_desc', $movie_desc);
    $stmt->bindParam(':movie_quality', $movie_quality);
    $stmt->bindParam(':movie_rating', $movie_rating);
    $stmt->bindParam(':movie_image', $filePath);
    $stmt->bindParam(':year', $movie_year, PDO::PARAM_INT);
    $stmt->bindParam(':views', $random_views, PDO::PARAM_INT);
    $stmt->bindParam(':type', $movie_type);
    $stmt->bindParam(':movie_url', $movie_url);

    if ($stmt->execute()) {
        header("Location: movies.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error adding the movie. Please check your data and try again.</div>";
    }
}
?>

<!-- HTML form and styling below -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
    background-color: #121212;
    color: #fff;
  }
  .form-container {
    background-color: #1e1e1e;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.5);
    margin-top: 50px;
  }
  .form-label {
    color: #ccc;
  }
  .btn-primary {
    background-color: #dc3545;
    border-color: #dc3545;
  }
  .btn-primary:hover {
    background-color: #c82333;
    border-color: #bd2130;
  }
  .form-control,
  .form-select {
    background-color: #292929;
    border: 1px solid #444;
    color: #fff;
  }
  .form-control:focus,
  .form-select:focus {
    background-color: #292929;
    color: #fff;
    border-color: #666;
    box-shadow: none;
  }
</style>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="form-container">
        <h2 class="mb-4 text-center">🎬 Add New Movie/Serial</h2>
        <form method="POST" action="addMovie.php" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="movie_name" class="form-label">Movie Name</label>
            <input type="text" class="form-control" id="movie_name" name="movie_name" required>
          </div>

          <div class="mb-3">
            <label for="movie_desc" class="form-label">Movie Description</label>
            <textarea class="form-control" id="movie_desc" name="movie_desc" rows="3" required></textarea>
          </div>

          <div class="mb-3">
            <label for="movie_quality" class="form-label">Movie Quality</label>
            <select class="form-select" id="movie_quality" name="movie_quality" required>
              <option value="HD">HD</option>
              <option value="Full HD">Full HD</option>
              <option value="4K">4K</option>
              <option value="SD">SD</option>
            </select>
          </div>

          <!-- <div class="mb-3">
            <label for="movie_rating" class="form-label">Movie Rating</label>
            <input type="number" class="form-control" id="movie_rating" name="movie_rating" min="0" max="10" step="0.1" required>
          </div> -->

          <div class="mb-3">
            <label for="movie_year" class="form-label">Movie Year</label>
            <select class="form-select" id="movie_year" name="movie_year" required>
              <?php 
              $currentYear = date('Y');
              for ($year = $currentYear; $year >= 2000; $year--) {
                  echo "<option value=\"$year\">$year</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="movie_type" class="form-label">Type</label>
            <select class="form-select" id="movie_type" name="movie_type" required>
              <option value="Movie">Movie</option>
              <option value="Serial">Serial</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="movie_image" class="form-label">Movie Image (Poster)</label>
            <input type="file" class="form-control" id="movie_image" name="movie_image" accept="image/*" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Upload Movie Video (mp4, mkv, avi, mov) <small>or</small> Enter Video URL</label>
            <input type="file" class="form-control mb-2" id="movie_url" name="movie_url" accept="video/*">
            <input type="url" class="form-control" id="movie_url_text" name="movie_url_text" placeholder="https://example.com/movie.mp4">
          </div>

          <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-primary">Add Movie/Serial</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once "footer.php"; ?>
