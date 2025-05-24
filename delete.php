<?php
include_once 'config.php';
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    // Only admins can delete users
    header("Location: user_dashboard.php");
    exit();
}

$id = $_GET['id'];

// Admin deletes any user by ID
$sql = "DELETE FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

header("Location: dashboard.php");
exit();
?>
