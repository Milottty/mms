<?php
include_once "config.php";
include_once "header.php";

// Check if the movie ID is provided via GET method
if (isset($_GET['id'])) {
    $movieId = $_GET['id'];

    // Prepare and execute SQL to fetch the movie data by ID
    $sql = "SELECT * FROM movies WHERE id = :id";
    $getMovie = $conn->prepare($sql);
    $getMovie->bindParam(':id', $movieId);
    $getMovie->execute();

    // Fetch the movie data
    $movie = $getMovie->fetch();

    // Check if the movie exists
    if (!$movie) {
        echo "Movie not found!";
        exit;
    }
} else {
    echo "Invalid movie ID!";
    exit;
}

// Handle form submission to update the movie
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated values from the form
    $movie_name = $_POST['movie_name'];
    $movie_desc = $_POST['movie_desc'];
    $movie_quality = $_POST['movie_quality'];
    $movie_rating = $_POST['movie_rating'];

    // Prepare and execute SQL to update the movie data
    $updateSql = "UPDATE movies SET movie_name = :movie_name, movie_desc = :movie_desc, movie_quality = :movie_quality, movie_rating = :movie_rating WHERE id = :id";
    $updateMovie = $conn->prepare($updateSql);
    $updateMovie->bindParam(':movie_name', $movie_name);
    $updateMovie->bindParam(':movie_desc', $movie_desc);
    $updateMovie->bindParam(':movie_quality', $movie_quality);
    $updateMovie->bindParam(':movie_rating', $movie_rating);
    $updateMovie->bindParam(':id', $movieId);

    // Execute the update query
    if ($updateMovie->execute()) {
        echo "Movie updated successfully!";
        header("Location: movies.php"); // Redirect to movies page
        exit;
    } else {
        echo "Failed to update the movie.";
    }
}
?>

<div class="d-flex" style="height: 100vh;">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
        <!-- Sidebar content -->
    </div>
    <div class="p-5">
        <h3>Edit Movie</h3>
        <form method="POST" action="movieEdit.php?id=<?php echo $movie['id']; ?>">
            <div class="mb-3">
                <label for="movie_name" class="form-label">Movie Name</label>
                <input type="text" class="form-control" id="movie_name" name="movie_name" value="<?php echo htmlspecialchars($movie['movie_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="movie_desc" class="form-label">Movie Description</label>
                <textarea class="form-control" id="movie_desc" name="movie_desc" required><?php echo htmlspecialchars($movie['movie_desc']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="movie_quality" class="form-label">Movie Quality</label>
                <select class="form-select" id="movie_quality" name="movie_quality" required>
                    <option value="HD" <?php if ($movie['movie_quality'] == 'HD') echo 'selected'; ?>>HD</option>
                    <option value="Full HD" <?php if ($movie['movie_quality'] == 'Full HD') echo 'selected'; ?>>Full HD</option>
                    <option value="4K" <?php if ($movie['movie_quality'] == '4K') echo 'selected'; ?>>4K</option>
                    <option value="SD" <?php if ($movie['movie_quality'] == 'SD') echo 'selected'; ?>>SD</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="movie_rating" class="form-label">Movie Rating</label>
                <input type="number" class="form-control" id="movie_rating" name="movie_rating" value="<?php echo htmlspecialchars($movie['movie_rating']); ?>" required min="1" max="10">
            </div>
            <button type="submit" class="btn btn-primary">Update Movie</button>
        </form>
    </div>
</div>

<?php
include_once "footer.php";
?>