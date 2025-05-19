<?php
include_once "config.php";
include_once "header.php";

if (isset($_POST['submit'])) {
    // Get data from the form
    $movie_name = $_POST['movie_name'];
    $movie_desc = $_POST['movie_desc'];
    $movie_quality = $_POST['movie_quality'];
    $movie_rating = $_POST['movie_rating'];
    // Define the upload directory
    $uploadDir = "uploads/";
    
    // Check if the upload directory exists, if not, create it
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Check if the file was uploaded
    if (isset($_FILES['movie_image']) && $_FILES['movie_image']['error'] == 0) {
        $fileName = basename($_FILES['movie_image']['name']);
        $filePath = $uploadDir . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['movie_image']['tmp_name'], $filePath)) {
            // Prepare and execute the SQL query
            $sql = "INSERT INTO movies (movie_name, movie_desc, movie_quality, movie_rating, movie_image) 
                    VALUES (:movie_name, :movie_desc, :movie_quality, :movie_rating, :movie_image)";
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':movie_name', $movie_name);
            $stmt->bindParam(':movie_desc', $movie_desc);
            $stmt->bindParam(':movie_quality', $movie_quality);
            $stmt->bindParam(':movie_rating', $movie_rating);
            $stmt->bindParam(':movie_image', $filePath);

            if ($stmt->execute()) {
                echo "Movie added successfully!";
                header("Location: movies.php");
                exit;
            } else {
                echo "Error adding the movie.";
            }
        } else {
            echo "Failed to upload the image.";
        }
    } else {
        echo "Please select a valid image file.";
    }
}
?>

<div class="container">
    <h2 class="mt-5">Add New Movie</h2>
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
            <label for="movie_image" class="form-label">Movie Image</label>
            <input type="file" class="form-control" id="movie_image" name="movie_image" accept="image/*" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Add Movie</button>
    </form>
</div>

<?php
include_once "footer.php";
?>
