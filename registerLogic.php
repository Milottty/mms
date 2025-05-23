<?php


include_once 'config.php';

if (isset($_POST['submit'])) {
    $emri = $_POST['emri'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $tempPass = $_POST['password'];
    $tempConfirm = $_POST['confirm_password'];
    $password = password_hash($tempPass, PASSWORD_DEFAULT);

  $profileImagePath = '';

if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["profile_image"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $fileName;

    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath)) {
        $profileImagePath = $targetFilePath;
    }
}


    if (empty($emri) || empty($username) || empty($email) || empty($tempPass) || empty($tempConfirm)) {
        echo "Please fill all the fields";
    } else {
        $sql = "INSERT INTO users(emri, username, email, password, confirm_password, is_admin, profile_image)
                VALUES (:emri, :username, :email, :password, :confirm_password, :is_admin, :profile_image)";
        
        $inserSql = $conn->prepare($sql);

        $isAdmin = "0";
        $inserSql->bindParam(':emri', $emri);
        $inserSql->bindParam(':username', $username);
        $inserSql->bindParam(':email', $email);
        $inserSql->bindParam(':password', $password);
        $inserSql->bindParam(':confirm_password', $password);
        $inserSql->bindParam(':is_admin', $isAdmin);
        $inserSql->bindParam(':profile_image', $$profileImagePath);

        $inserSql->execute();

        header("Location: login.php");
        exit();
    }
}
