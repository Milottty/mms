<?php
include_once "config.php";
include_once "header.php";

if (isset($_POST['submit'])) {
    // Get data from the form
    $movie_name = $_POST['movie_name'];
    $movie_desc = $_POST['movie_desc'];
    $movie_quality = $_POST['movie_quality'];
    $movie_rating = $_POST['movie_rating'];

    // Check if any field is empty
    if (empty($movie_name) || empty($movie_desc) || empty($movie_quality) || empty($movie_rating)) {
        echo "Please fill all the fields.";
    } else {
        // Prepare and execute the SQL query
        $sql = "INSERT INTO movies (movie_name, movie_desc, movie_quality, movie_rating) VALUES (:movie_name, :movie_desc, :movie_quality, :movie_rating)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':movie_name', $movie_name);
        $stmt->bindParam(':movie_desc', $movie_desc);
        $stmt->bindParam(':movie_quality', $movie_quality);
        $stmt->bindParam(':movie_rating', $movie_rating);

        // Execute the query
        if ($stmt->execute()) {
            echo "Movie added successfully!";
            header("Location: movies.php");  // Redirect to the movies page after adding the movie
        } else {
            echo "Error adding the movie.";
        }
    }
}
?>

<div class="container">
    <h2 class="mt-5">Add New Movie</h2>
    <form method="POST" action="addMovie.php">
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
        <button type="submit" name="submit" class="btn btn-primary">Add Movie</button>
    </form>
</div>

<?php
include_once "footer.php";
?>