    <?php
    include_once "config.php";


    session_start();
    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
        header("Location: movies.php");
        exit();
    }


if (isset($_GET['id'])) {
    $movieId = $_GET['id'];


    $checkSql = "SELECT * FROM movies WHERE id = :id";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':id', $movieId, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->rowCount() === 0) {
        echo "Movie not found.";
        exit;
    }


    $deleteWatchlistSql = "DELETE FROM watchlist WHERE movie_id = :id";
    $deleteWatchlistStmt = $conn->prepare($deleteWatchlistSql);
    $deleteWatchlistStmt->bindParam(':id', $movieId, PDO::PARAM_INT);
    $deleteWatchlistStmt->execute();


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