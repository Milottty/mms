<?php
include_once "config.php";

// Check if the ID is passed via GET
if (isset($_GET['id'])) {
    $movieId = $_GET['id'];

    // First, check if the movie exists
    $checkSql = "SELECT * FROM movies WHERE id = :id";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':id', $movieId, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->rowCount() === 0) {
        echo "Movie not found.";
        exit;
    }

    // Delete the movie
    $deleteSql = "DELETE FROM movies WHERE id = :id";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bindParam(':id', $movieId, PDO::PARAM_INT);

    if ($deleteStmt->execute()) {
        header("Location: movies.php?message=Movie+deleted+successfully");
        exit;
    } else {
        echo "Failed to delete the movie.";
    }
} else {
    echo "Invalid movie ID.";
}
