<?php
include_once 'config.php';

if(isset($_POST['submit'])) {
    $emri = $_POST['emri'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $tempPass = $_POST['password'];
    $password = password_hash($tempPass, PASSWORD_DEFAULT);
    $tempConfirm = $_POST['confirm_password'];
    $confirm_password = password_hash($tempPass, PASSWORD_DEFAULT);
    
    if (empty($emri) || empty($username) || empty($email) || empty($tempPass) || empty($confirm_password)) {
        echo"Please fill all the fields";
    }else{
        $sql = "INSERT INTO users(emri, username, email, password, confirm_password, is_admin) VALUES (:emri, :username, :email, :password, :confirm_password, :is_admin)";
        
        $inserSql = $conn->prepare($sql);

        $isAdmin = "0";
        $inserSql->bindParam(':emri', $emri);
        $inserSql->bindParam(':username', $username);
        $inserSql->bindParam(':email', $email);
        $inserSql->bindParam(':password', $password);
        $inserSql->bindParam(':confirm_password', $confirm_password);
        $inserSql->bindParam(':is_admin', $isAdmin);

        $inserSql->execute();

        header("Location: login.php");
        
    }

}