<?php
include_once 'config.php';
session_start();

$id = $_GET['id'];

// Check if the user is deleting their own account
$sqlCheck = "SELECT username FROM users WHERE id = :id";
$checkStmt = $conn->prepare($sqlCheck);
$checkStmt->bindParam(':id', $id);
$checkStmt->execute();
$user = $checkStmt->fetch();

if ($user && $user['username'] === $_SESSION['username']) {
    // Delete the user
    $sql = "DELETE FROM users WHERE id = :id";
    $sqlUsers = $conn->prepare($sql);
    $sqlUsers->bindParam(":id", $id);
    $sqlUsers->execute();

    // Log the user out
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// If user tries to delete someone else (not allowed), just redirect
header("Location: dashboard.php");
exit();
