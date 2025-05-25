<?php
include_once "config.php";

if (!isset($_GET['cinema'])) {
    echo json_encode([]);
    exit;
}

$cinema = $_GET['cinema'];

// Secure query to get only 5 random movies from the selected cinema
$stmt = $conn->prepare("SELECT id, movie_name FROM movies WHERE cinema = ? ORDER BY RAND() LIMIT 5");
$stmt->execute([$cinema]);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output JSON
header('Content-Type: application/json');
echo json_encode($movies);
