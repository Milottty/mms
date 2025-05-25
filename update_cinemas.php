<?php
include_once "config.php";

$cinemas = ['Cineplex', 'Cinestar'];

// Select movies where cinema is NULL
$sqlSelect = "SELECT id FROM movies WHERE cinema IS NULL";
$stmtSelect = $conn->prepare($sqlSelect);
$stmtSelect->execute();
$moviesWithoutCinema = $stmtSelect->fetchAll();

foreach ($moviesWithoutCinema as $movie) {
    $randomCinema = $cinemas[array_rand($cinemas)];

    $sqlUpdate = "UPDATE movies SET cinema = :cinema WHERE id = :id";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':cinema', $randomCinema);
    $stmtUpdate->bindParam(':id', $movie['id']);
    $stmtUpdate->execute();
}

echo "Updated " . count($moviesWithoutCinema) . " movies with random cinema values.";
?>
