<?php
include_once "config.php";
include_once "header.php";

if (isset($_POST['submit'])) {
    $movie_name = $_POST['movie_name'];
    $movie_desc = $_POST['movie_desc'];
    $movie_quality = $_POST['movie_quality'];
    $movie_rating = $_POST['movie_rating'];
    $movie_year = $_POST['movie_year'];

    // Generate random views between 0 and 1000
    $random_views = rand(0, 1000);

    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES['movie_image']) && $_FILES['movie_image']['error'] == 0) {
        $fileName = basename($_FILES['movie_image']['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['movie_image']['tmp_name'], $filePath)) {
            $sql = "INSERT INTO movies (movie_name, movie_desc, movie_quality, movie_rating, movie_image, year, views) 
                    VALUES (:movie_name, :movie_desc, :movie_quality, :movie_rating, :movie_image, :year, :views)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':movie_name', $movie_name);
            $stmt->bindParam(':movie_desc', $movie_desc);
            $stmt->bindParam(':movie_quality', $movie_quality);
            $stmt->bindParam(':movie_rating', $movie_rating);
            $stmt->bindParam(':movie_image', $filePath);
            $stmt->bindParam(':year', $movie_year, PDO::PARAM_INT);
            $stmt->bindParam(':views', $random_views, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: movies.php");
                exit;
            } else {
                echo "<div class='alert alert-danger'>Error adding the movie.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Failed to upload the image.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Please select a valid image file.</div>";
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
        <h2 class="mb-4 text-center">🎬 Add New Movie</h2>
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
          <div class="mb-3">
            <label for="movie_rating" class="form-label">Movie Rating</label>
            <input type="number" class="form-control" id="movie_rating" name="movie_rating" min="0" max="10" required>
          </div>
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
            <label for="movie_image" class="form-label">Movie Image</label>
            <input type="file" class="form-control" id="movie_image" name="movie_image" accept="image/*" required>
          </div>
          <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-primary">Add Movie</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once "footer.php"; ?>
