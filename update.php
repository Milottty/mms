<?php
session_start();
include_once 'config.php';


session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    // Not admin, block access and redirect
    header("Location: movies.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    if (!$id) {
        header("Location: user_dashboard.php");
        exit();
    }

    // Verify ownership before updating
    $stmtCheck = $conn->prepare("SELECT username FROM users WHERE id = :id");
    $stmtCheck->bindParam(':id', $id);
    $stmtCheck->execute();
    $user = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['username'] === $_SESSION['username']) {
        $emri = $_POST['emri'] ?? '';
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';

        // Optional: Add validation and sanitize input here

        $sql = "UPDATE users SET emri = :emri, username = :username, email = :email WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':emri', $emri);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Update session username if changed
        if ($username !== $_SESSION['username']) {
            $_SESSION['username'] = $username;
        }
    }
}

header("Location: user_dashboard.php");
exit();
