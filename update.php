<?php


include_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Verify ownership
    $check = $conn->prepare("SELECT username FROM users WHERE id = :id");
    $check->bindParam(':id', $id);
    $check->execute();
    $user = $check->fetch();

    if ($user && $user['username'] === $_SESSION['username']) {
        $emri = $_POST['emri'];
        $username = $_POST['username'];
        $email = $_POST['email'];

        $sql = "UPDATE users SET emri = :emri, username = :username, email = :email WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':emri', $emri);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

header("Location: dashboard.php");
exit();
