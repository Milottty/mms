<?php

    include_once 'config.php';

    $name = $_POST['emri'];
    $surname = $_POST['username'];
    $email = $_POST['email'];
    $id = $_POST['id'];


    $sql = "UPDATE users SET emri=:emri, username=:username, email=:email WHERE id=:id";

    $prep = $conn->prepare($sql);
    $prep->bindParam(":emri", $name);
    $prep->bindParam(":username", $surname);
    $prep->bindParam(":email", $email);
    $prep->bindParam(":id", $id);
    $prep->execute();

    header("Location: dashboard.php");